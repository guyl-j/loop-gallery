<?php

if (!defined('ABSPATH')) {
    exit;
}

class OLG_Offer_Loop_Gallery extends \Elementor\Widget_Base {

    public function get_name() {
        return 'offer_loop_gallery';
    }

    public function get_title() {
        return 'Offer Loop Gallery';
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_style_depends() {
        return ['olg-gallery'];
    }

    public function get_script_depends() {
        return ['olg-gallery'];
    }

    // ======================================
    // REGISTER CONTROLS
    // ======================================

    protected function register_controls() {

        // CONTENT SETTINGS

        $this->start_controls_section(
            'olg_content',
            [
                'label' => 'Offers',
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'offer_image',
            [
                'label' => 'Offer Image',
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        $repeater->add_control(
            'offer_title',
            [
                'label' => 'Offer Title',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Your Offer Title',
                'label_block' => true,
            ]
        );

        // INDIVIDUAL BUTTON TEXT

        $repeater->add_control(
            'offer_button_text',
            [
                'label' => 'Button Text',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Shop Now',
                'label_block' => true,
            ]
        );

        // INDIVIDUAL BUTTON HOVER TEXT

        $repeater->add_control(
            'offer_button_hover_text',
            [
                'label' => 'Button Hover Text',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Discover More',
                'label_block' => true,
            ]
        );

        // OFFER LINK

        $repeater->add_control(
            'offer_link',
            [
                'label' => 'Offer Link',
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://yourwebsite.com',
                'options' => ['url', 'is_external', 'nofollow'],
                'default' => ['url' => ''],
            ]
        );

        // OFFER ITEMS

        $this->add_control(
            'offers',
            [
                'label' => 'Offer Items',
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ offer_title }}}',
                'default' => [],
            ]
        );

        // SHOW / HIDE IMAGE BUTTON

        $this->add_control(
            'show_overlay_button',
            [
                'label' => 'Show Image Button',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'Yes',
                'label_off' => 'No',
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        // AUTOMATIC SCROLLING

        $this->add_control(
            'autoplay',
            [
                'label' => 'Automatic Scrolling',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
		
		$this->add_control(
   			'scroll_direction',
    		[
        		'label' => 'Scrolling Direction',
        		'type' => \Elementor\Controls_Manager::SELECT,
       			'default' => 'left',
      			'options' => [
            	'left' => 'Right to Left',
            	'right' => 'Left to Right',
        		],
        		'condition' => [
            	'autoplay' => 'yes',
        		],
    		]
		);

        // SCROLL SPEED

        $this->add_control(
            'speed',
            [
                'label' => 'Scroll Speed',
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 35,
                'min' => 5,
                'max' => 150,
            ]
        );

        // PAUSE ON HOVER

        $this->add_control(
            'pause_hover',
            [
                'label' => 'Pause on Hover',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();


        // ======================================
        // IMAGE SETTINGS
        // ======================================

        $this->start_controls_section(
            'olg_images',
            [
                'label' => 'Image Settings',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // IMAGE WIDTH

        $this->add_responsive_control(
            'image_width',
            [
                'label' => 'Image Width',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => 100, 'max' => 700],
                    '%' => ['min' => 10, 'max' => 100],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 280,
                ],
                'selectors' => [
                    '{{WRAPPER}} .olg-card' =>
                        'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // IMAGE HEIGHT

        $this->add_responsive_control(
            'image_height',
            [
                'label' => 'Image Height',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 100, 'max' => 800],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 350,
                ],
                'selectors' => [
                    '{{WRAPPER}} .olg-image-wrap' =>
                        'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // IMAGE FIT

        $this->add_control(
            'image_fit',
            [
                'label' => 'Image Fit',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'cover' => 'Cover - Fill Image Frame',
                    'contain' => 'Contain - Show Full Image',
                    'fill' => 'Fill - Stretch Image',
                ],
                'selectors' => [
                    '{{WRAPPER}} .olg-image' =>
                        'object-fit: {{VALUE}};',
                ],
            ]
        );

        // IMAGE POSITION

        $this->add_control(
            'image_position',
            [
                'label' => 'Image Position',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'center center',
                'options' => [
                    'center center' => 'Centre',
                    'center top' => 'Top',
                    'center bottom' => 'Bottom',
                    'left center' => 'Left',
                    'right center' => 'Right',
                ],
                'selectors' => [
                    '{{WRAPPER}} .olg-image' =>
                        'object-position: {{VALUE}};',
                ],
            ]
        );

        // IMAGE GAP

        $this->add_responsive_control(
            'image_gap',
            [
                'label' => 'Space Between Images',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 150],
                ],
                'default' => ['size' => 25],
                'selectors' => [
                    '{{WRAPPER}} .olg-gallery' =>
                        '--olg-gap: {{SIZE}}px;',
                ],
            ]
        );

        // VERTICAL OFFSET

        $this->add_control(
            'vertical_offset',
            [
                'label' => 'Alternating Vertical Offset',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 150],
                ],
                'default' => ['size' => 20],
                'selectors' => [
                    '{{WRAPPER}} .olg-gallery' =>
                        '--olg-offset: {{SIZE}}px;',
                ],
            ]
        );
		
		
// EXTRA TOP SPACING

$this->add_responsive_control(
    'extra_top_spacing',
    [
        'label' => 'Extra Top Spacing',
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 150,
            ],
        ],
        'default' => [
            'size' => 0,
        ],
        'selectors' => [
            '{{WRAPPER}} .olg-group' =>
                '--olg-extra-top: {{SIZE}}px;',
        ],
    ]
);

// EXTRA BOTTOM SPACING

$this->add_responsive_control(
    'extra_bottom_spacing',
    [
        'label' => 'Extra Bottom Spacing',
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 150,
            ],
        ],
        'default' => [
            'size' => 0,
        ],
        'selectors' => [
            '{{WRAPPER}} .olg-group' =>
                '--olg-extra-bottom: {{SIZE}}px;',
        ],
    ]
);


        // IMAGE BORDER RADIUS

        $this->add_control(
            'image_radius',
            [
                'label' => 'Image Border Radius',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .olg-image-wrap, {{WRAPPER}} .olg-image' =>
                        'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // IMAGE SHADOW

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_box_shadow',
                'label' => 'Image Shadow',
                'selector' => '{{WRAPPER}} .olg-image-wrap',
            ]
        );

        // IMAGE HOVER SHADOW

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_hover_shadow',
                'label' => 'Image Hover Shadow',
                'selector' => '{{WRAPPER}} .olg-card:hover .olg-image-wrap',
            ]
        );

        $this->end_controls_section();


        // ======================================
        // OVERLAY BUTTON STYLE
        // ======================================

        $this->start_controls_section(
            'olg_button_style',
            [
                'label' => 'Image Overlay Button',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // BUTTON TYPOGRAPHY

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'overlay_button_typography',
                'selector' => '{{WRAPPER}} .olg-overlay-button',
            ]
        );

        // TEXT COLOUR

        $this->add_control(
            'overlay_button_colour',
            [
                'label' => 'Text Colour',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .olg-overlay-button' =>
                        'color: {{VALUE}};',
                ],
            ]
        );

        // HOVER TEXT COLOUR

        $this->add_control(
            'overlay_button_hover_colour',
            [
                'label' => 'Hover Text Colour',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .olg-overlay-button' =>
                        '--olg-button-hover-colour: {{VALUE}};',
                ],
            ]
        );

        // BACKGROUND

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'overlay_button_background',
                'label' => 'Background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .olg-overlay-button',
            ]
        );

        // HOVER BACKGROUND

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'overlay_button_hover_background',
                'label' => 'Hover Background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .olg-card:hover .olg-overlay-button',
            ]
        );

        // BORDER

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'overlay_button_border',
                'label' => 'Button Border',
                'selector' => '{{WRAPPER}} .olg-overlay-button',
            ]
        );

        // HOVER BORDER

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'overlay_button_hover_border',
                'label' => 'Hover Button Border',
                'selector' => '{{WRAPPER}} .olg-card:hover .olg-overlay-button',
            ]
        );

        // BORDER RADIUS

        $this->add_control(
            'overlay_button_radius',
            [
                'label' => 'Border Radius',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .olg-overlay-button' =>
                        'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // BUTTON PADDING

        $this->add_responsive_control(
            'overlay_button_padding',
            [
                'label' => 'Button Padding',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .olg-overlay-button' =>
                        'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        // ======================================
        // TITLE TYPOGRAPHY
        // ======================================

        $this->start_controls_section(
            'olg_title_style',
            [
                'label' => 'Title Typography',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .olg-title',
            ]
        );

        // TITLE COLOUR

        $this->add_control(
            'title_colour',
            [
                'label' => 'Title Colour',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .olg-title' =>
                        'color: {{VALUE}};',
                ],
            ]
        );

        // TITLE HOVER COLOUR

        $this->add_control(
            'title_hover_colour',
            [
                'label' => 'Title Hover Colour',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .olg-card:hover .olg-title' =>
                        'color: {{VALUE}};',
                ],
            ]
        );

        // TITLE SPACING

        $this->add_responsive_control(
            'title_spacing',
            [
                'label' => 'Space Above Title',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 100],
                ],
                'default' => ['size' => 15],
                'selectors' => [
                    '{{WRAPPER}} .olg-title' =>
                        'margin-top: {{SIZE}}px;',
                ],
            ]
        );

        $this->end_controls_section();

    }


    // ======================================
    // RENDER GALLERY
    // ======================================

    protected function render() {

        $settings = $this->get_settings_for_display();

        $offers = $settings['offers'] ?? [];

        if (empty($offers)) {
            echo '<p>Please add some offer items.</p>';
            return;
        }

        $autoplay = ($settings['autoplay'] ?? '') === 'yes'
            ? 'true'
            : 'false';

        $pause = ($settings['pause_hover'] ?? '') === 'yes'
            ? 'true'
            : 'false';

        $speed = max(
            5,
            min(150, (int) ($settings['speed'] ?? 35))
        );
		
		$direction = ($settings['scroll_direction'] ?? 'left') === 'right'
   			? 'right'
    		: 'left';

        $show_button = ($settings['show_overlay_button'] ?? '') === 'yes';

        ?>

        
<div class="olg-gallery"
     data-autoplay="<?php echo esc_attr($autoplay); ?>"
     data-pause="<?php echo esc_attr($pause); ?>"
     data-speed="<?php echo esc_attr($speed); ?>"
     data-direction="<?php echo esc_attr($direction); ?>">


            <div class="olg-viewport">

                <div class="olg-track">

                    <div class="olg-group">

                        <?php foreach ($offers as $index => $offer) :

                            $image_id = $offer['offer_image']['id'] ?? 0;

                            $image_url = $image_id
                                ? wp_get_attachment_image_url(
                                    $image_id,
                                    'large'
                                )
                                : '';

                            if (!$image_url) {
                                continue;
                            }

                            $title = $offer['offer_title'] ?? '';

                            $link = $offer['offer_link']['url'] ?? '';

                            $external = !empty(
                                $offer['offer_link']['is_external']
                            );

                            $nofollow = !empty(
                                $offer['offer_link']['nofollow']
                            );

                            // INDIVIDUAL BUTTON TEXT

                            $button_text = $offer['offer_button_text'] ?? 'Shop Now';

                            $button_hover_text = $offer['offer_button_hover_text'] ?? '';

                            $position_class = ($index % 2 === 0)
                                ? 'olg-card-up'
                                : 'olg-card-down';

                        ?>

                            <div class="olg-card <?php echo esc_attr($position_class); ?>">

                                <?php if ($link) : ?>

                                    <a class="olg-link"
                                       href="<?php echo esc_url($link); ?>"
                                       <?php if ($external) : ?>
                                           target="_blank"
                                           rel="noopener noreferrer<?php echo $nofollow ? ' nofollow' : ''; ?>"
                                       <?php elseif ($nofollow) : ?>
                                           rel="nofollow"
                                       <?php endif; ?>>

                                <?php endif; ?>

                                    <div class="olg-image-wrap">

                                        <img
                                            class="olg-image"
                                            src="<?php echo esc_url($image_url); ?>"
                                            alt="<?php echo esc_attr($title); ?>"
                                            loading="lazy"
                                            draggable="false"
                                        >

                                        <?php if ($show_button && $button_text) : ?>

                                            <span class="olg-overlay-button" aria-hidden="true">

                                                <span class="olg-button-text">
                                                    <?php echo esc_html($button_text); ?>
                                                </span>

                                                <span class="olg-button-hover-text">
                                                    <?php echo esc_html($button_hover_text ?: $button_text); ?>
                                                </span>

                                            </span>

                                        <?php endif; ?>

                                    </div>

                                    <?php if ($title) : ?>

                                        <div class="olg-title">
                                            <?php echo esc_html($title); ?>
                                        </div>

                                    <?php endif; ?>

                                <?php if ($link) : ?>

                                    </a>

                                <?php endif; ?>

                            </div>

                        <?php endforeach; ?>

                    </div>

                </div>

            </div>

        </div>

        <?php
    }

}
