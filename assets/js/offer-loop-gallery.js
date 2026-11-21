(function () {

    'use strict';

    function initOfferGallery(gallery) {

        if (gallery.dataset.olgReady === 'true') {
            return;
        }

        const track = gallery.querySelector('.olg-track');
        const viewport = gallery.querySelector('.olg-viewport');
        const original = track && track.querySelector('.olg-group');

        if (!track || !viewport || !original) return;
        if (!original.children.length) return;

        gallery.dataset.olgReady = 'true';

        // ======================================
        // SETTINGS
        // ======================================

        let cycleWidth = 0;
        let position = 0;
        let beforeCount = 0;

        let lastTime = 0;
        let animationFrame = null;

        let dragging = false;
        let startX = 0;
        let lastX = 0;
        let moved = false;

        let resizeTimer = null;
        let hovering = false;

        let resizeObserver = null;
        let mutationObserver = null;

        const autoplay =
            gallery.dataset.autoplay === 'true';

        const pauseOnHover =
            gallery.dataset.pause === 'true';

        const speed = Math.max(
            5,
            Math.min(150, Number(gallery.dataset.speed) || 35)
		);	
		
		const direction = gallery.dataset.direction === 'right'
   			 ? 1
  			 : -1;	
        

        // ======================================
        // CREATE ACCESSIBLE CLONES
        // ======================================

        function createClone() {

            const clone = original.cloneNode(true);

            clone.classList.add('olg-clone');

            clone.setAttribute('aria-hidden', 'true');

            clone.querySelectorAll('a').forEach(function (link) {
                link.setAttribute('tabindex', '-1');
            });

            clone.querySelectorAll('img').forEach(function (img) {
                img.setAttribute('draggable', 'false');
            });

            return clone;
        }

        // ======================================
        // BUILD CONTINUOUS TRACK
        // ======================================

        function buildTrack() {

            // Remove previously generated clones.

            track.querySelectorAll('.olg-clone').forEach(function (clone) {
                clone.remove();
            });

            cycleWidth = original.getBoundingClientRect().width;

            if (cycleWidth <= 0) return;

            // Create enough copies to cover the viewport
            // in both directions, including a safety margin.

            const copies = Math.ceil(
                viewport.clientWidth / cycleWidth
            ) + 2;

            beforeCount = copies;

            const beforeFragment = document.createDocumentFragment();
            const afterFragment = document.createDocumentFragment();

            for (let i = 0; i < copies; i++) {
                beforeFragment.appendChild(createClone());
                afterFragment.appendChild(createClone());
            }

            track.insertBefore(beforeFragment, original);
            track.appendChild(afterFragment);

            // Start at the original group's position.

            position = -(beforeCount * cycleWidth);

            updatePosition();

        }

        // ======================================
        // MEASURE
        // ======================================

        function measure() {

            const newWidth =
                original.getBoundingClientRect().width;

            if (newWidth <= 0) return;

            if (Math.abs(newWidth - cycleWidth) > 0.5) {
                buildTrack();
            }

        }

        // ======================================
        // UPDATE POSITION
        // ======================================

        function updatePosition() {

            track.style.transform =
                'translate3d(' + position + 'px, 0, 0)';

        }

        // ======================================
        // SEAMLESS LOOP NORMALISATION
        // ======================================

        function normalize() {

            if (!cycleWidth) return;

            const lowerLimit =
                -(beforeCount + 1) * cycleWidth;

            const upperLimit =
                -(beforeCount - 1) * cycleWidth;

            while (position <= lowerLimit) {
                position += cycleWidth;
            }

            while (position > upperLimit) {
                position -= cycleWidth;
            }

        }

        // ======================================
        // ANIMATION
        // ======================================

        function animate(time) {

            if (!lastTime) {
                lastTime = time;
            }

            const delta = Math.min(
                (time - lastTime) / 1000,
                0.05
            );

            lastTime = time;

            if (
                autoplay &&
                !dragging &&
                !(pauseOnHover && hovering) &&
                cycleWidth > 0
            ) {

                position += direction * speed * delta;

                normalize();

                updatePosition();

            }

            animationFrame =
                requestAnimationFrame(animate);

        }

        // ======================================
        // DRAGGING
        // ======================================

        function pointerDown(event) {

            if (
                event.pointerType === 'mouse' &&
                event.button !== 0
            ) {
                return;
            }

            dragging = true;
            moved = false;

            startX = event.clientX;
            lastX = event.clientX;

            // Do not capture the pointer on press: doing so can
            // redirect a normal link click to the viewport.

        }

        function pointerMove(event) {

            if (!dragging) return;

            const delta = event.clientX - lastX;

            if (!moved && Math.abs(event.clientX - startX) > 5) {
                moved = true;
                viewport.classList.add('is-dragging');

                try {
                    viewport.setPointerCapture(event.pointerId);
                } catch (error) {}
            }

            if (!moved) {
                lastX = event.clientX;
                return;
            }

            position += delta;
            lastX = event.clientX;

            normalize();
            updatePosition();

        }

        function pointerUp(event) {

            if (!dragging) return;

            dragging = false;

            viewport.classList.remove('is-dragging');

            try {

                if (viewport.hasPointerCapture(event.pointerId)) {
                    viewport.releasePointerCapture(event.pointerId);
                }

            } catch (error) {}

        }

        viewport.addEventListener('pointerdown', pointerDown);
        viewport.addEventListener('pointermove', pointerMove);
        viewport.addEventListener('pointerup', pointerUp);
        viewport.addEventListener('pointercancel', pointerUp);
        viewport.addEventListener('lostpointercapture', pointerUp);

        // ======================================
        // PREVENT CLICK AFTER DRAG
        // ======================================

        viewport.addEventListener('click', function (event) {

            if (moved) {

                event.preventDefault();
                event.stopPropagation();

            }

            moved = false;

        }, true);

        viewport.addEventListener('dragstart', function (event) {
            event.preventDefault();
        });

        // ======================================
        // PAUSE ON HOVER
        // ======================================

        if (pauseOnHover) {

            viewport.addEventListener('mouseenter', function () {
                hovering = true;
            });

            viewport.addEventListener('mouseleave', function () {
                hovering = false;
            });

        }

        // ======================================
        // WAIT FOR IMAGES
        // ======================================

        function waitForImages() {

            const images = Array.from(
                original.querySelectorAll('img')
            );

            return Promise.all(images.map(function (img) {

                if (img.complete) {
                    return Promise.resolve();
                }

                return new Promise(function (resolve) {

                    img.addEventListener('load', resolve, {
                        once: true
                    });

                    img.addEventListener('error', resolve, {
                        once: true
                    });

                });

            }));

        }

        // ======================================
        // INITIALISE
        // ======================================

        function initialise() {

            buildTrack();

            if (autoplay && !animationFrame) {

                lastTime = 0;

                animationFrame =
                    requestAnimationFrame(animate);

            }

        }

        waitForImages().then(function () {

            requestAnimationFrame(function () {

                requestAnimationFrame(initialise);

            });

        });

        // ======================================
        // RESIZE
        // ======================================

        function handleResize() {

            clearTimeout(resizeTimer);

            resizeTimer = setTimeout(function () {

                if (!gallery.isConnected) return;

                buildTrack();

            }, 150);

        }

        window.addEventListener('resize', handleResize);

        if (window.ResizeObserver) {

            resizeObserver = new ResizeObserver(function () {

                const newWidth =
                    original.getBoundingClientRect().width;

                if (
                    newWidth > 0 &&
                    Math.abs(newWidth - cycleWidth) > 0.5
                ) {
                    buildTrack();
                }

            });

            resizeObserver.observe(original);
            resizeObserver.observe(viewport);

        }

        // ======================================
        // CLEANUP
        // ======================================

        if (window.MutationObserver) {

            mutationObserver = new MutationObserver(function () {

                if (!gallery.isConnected) {

                    if (animationFrame) {
                        cancelAnimationFrame(animationFrame);
                    }

                    clearTimeout(resizeTimer);

                    window.removeEventListener(
                        'resize',
                        handleResize
                    );

                    if (resizeObserver) {
                        resizeObserver.disconnect();
                    }

                    mutationObserver.disconnect();

                }

            });

            mutationObserver.observe(document.body, {
                childList: true,
                subtree: true
            });

        }

    }

    // ======================================
    // INITIALISE ALL GALLERIES
    // ======================================

    function initAll() {

        document.querySelectorAll('.olg-gallery').forEach(
            initOfferGallery
        );

    }

    if (document.readyState === 'loading') {

        document.addEventListener('DOMContentLoaded', initAll);

    } else {

        initAll();

    }

    // ======================================
    // ELEMENTOR EDITOR SUPPORT
    // ======================================

    if (window.jQuery) {

        jQuery(window).on('elementor/frontend/init', function () {

            if (!window.elementorFrontend) return;

            elementorFrontend.hooks.addAction(
                'frontend/element_ready/offer_loop_gallery.default',
                function ($scope) {

                    $scope[0]
                        .querySelectorAll('.olg-gallery')
                        .forEach(initOfferGallery);

                }
            );

        });

    }

})();
