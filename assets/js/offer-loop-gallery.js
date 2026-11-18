/* ==========================================
   OFFER LOOP GALLERY
   VERSION 1.6
========================================== */


/* MAIN GALLERY */

.olg-gallery {
    width: 100%;
    position: relative;
    overflow: hidden;
    padding: 0;

    --olg-offset: 20px;
    --olg-gap: 25px;

    box-sizing: border-box;
}


/* VIEWPORT */

.olg-viewport {
    width: 100%;
    overflow: hidden;
    cursor: grab;
    touch-action: pan-y;
    user-select: none;
    box-sizing: border-box;
}

.olg-viewport.is-dragging {
    cursor: grabbing;
}


/* TRACK */

.olg-track {
    display: flex;
    width: max-content;
    will-change: transform;
}


/* GROUP */

.olg-group {
    display: flex;
    flex: 0 0 auto;
    align-items: flex-start;

    gap: var(--olg-gap);

    padding-top: calc(var(--olg-offset) + var(--olg-extra-top, 0px));
    padding-bottom: calc(var(--olg-offset) + var(--olg-extra-bottom, 0px));
    padding-right: var(--olg-gap);

    box-sizing: border-box;
}


/* CARDS */

.olg-card {
    flex: 0 0 auto;
    width: 280px;
    min-width: 0;
    position: relative;
    box-sizing: border-box;
}


/* ALTERNATING POSITIONS */

.olg-card-up {
    top: calc(var(--olg-offset) * -1);
}

.olg-card-down {
    top: var(--olg-offset);
}


/* LINKS */

.olg-link {
    display: block;
    width: 100%;
    color: inherit;
    text-decoration: none;
}


/* IMAGE FRAME */

.olg-image-wrap {
    display: block;
    position: relative;

    width: 100%;
    height: 350px;

    overflow: hidden;

    background-color: #f2f2f2;

    box-sizing: border-box;

    transition: box-shadow 0.35s ease;
}


/* IMAGE */

.olg-image {
    display: block;

    width: 100%;
    height: 100%;
    max-width: none;

    object-fit: cover;
    object-position: center center;

    border-radius: inherit;

    margin: 0;
    padding: 0;

    pointer-events: none;
    transform: none;

    transition: transform 0.35s ease;

    box-sizing: border-box;
}


/* IMAGE HOVER */

.olg-card:hover .olg-image {
    transform: scale(1.025);
}


/* TITLES */

.olg-title {
    display: block;
    position: relative;

    width: 100%;

    margin-top: 15px;
    margin-bottom: 0;

    padding: 0;

    font-size: 20px;
    font-weight: 600;
    line-height: 1.4;

    white-space: normal;
    overflow: visible;
    overflow-wrap: break-word;

    box-sizing: border-box;
    z-index: 2;

    transition: color 0.3s ease;
}


/* ACCESSIBILITY */

.olg-card a:focus-visible {
    outline: 2px solid currentColor;
    outline-offset: 5px;
}


/* TABLET */

@media (max-width: 1024px) {

    .olg-card {
        width: 240px;
    }

    .olg-image-wrap {
        height: 300px;
    }

}


/* MOBILE */

@media (max-width: 767px) {

    .olg-card {
        width: 72vw;
    }

    .olg-image-wrap {
        height: 300px;
    }

    .olg-title {
        font-size: 17px;
        line-height: 1.4;
    }

}


/* ==========================================
   OFFER IMAGE OVERLAY BUTTON
========================================== */


/* BUTTON */

.olg-overlay-button {
    position: absolute;

    top: 50%;
    left: 50%;

    transform: translate(-50%, -50%);

    display: inline-flex;
    align-items: center;
    justify-content: center;

    width: max-content;
    max-width: calc(100% - 30px);

    padding: 12px 28px;

    box-sizing: border-box;

    font-size: 15px;
    font-weight: 600;
    line-height: 1.2;

    text-align: center;
    white-space: nowrap;

    cursor: pointer;

    z-index: 5;

    transition:
        background-color 0.3s ease,
        color 0.3s ease,
        border-color 0.3s ease,
        transform 0.3s ease;
}


/* DEFAULT BUTTON TEXT */

.olg-button-text {
    display: block;
    transition: opacity 0.25s ease;
}


/* HOVER BUTTON TEXT */

.olg-button-hover-text {
    display: block;

    position: absolute;

    top: 50%;
    left: 50%;

    width: 100%;

    transform: translate(-50%, -50%);

    opacity: 0;

    text-align: center;
    white-space: nowrap;

    transition: opacity 0.25s ease;

    pointer-events: none;
}


/* HOVER TEXT SWITCH */

@media (hover: hover) {

    .olg-card:hover .olg-button-text {
        opacity: 0;
    }

    .olg-card:hover .olg-button-hover-text {
        opacity: 1;
    }

}


/* KEYBOARD ACCESSIBILITY */

.olg-card:focus-within .olg-button-text {
    opacity: 0;
}

.olg-card:focus-within .olg-button-hover-text {
    opacity: 1;
}


/* KEEP BUTTON ABOVE IMAGE */

.olg-overlay-button,
.olg-button-text,
.olg-button-hover-text {
    pointer-events: none;
}


/* ==========================================
   REDUCED MOTION
========================================== */

@media (prefers-reduced-motion: reduce) {

    .olg-image,
    .olg-image-wrap,
    .olg-overlay-button,
    .olg-button-text,
    .olg-button-hover-text {
        transition: none;
    }

}
