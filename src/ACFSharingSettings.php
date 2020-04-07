<?php

namespace Dashifen\ACFSharingSettings;

use Timber\Timber;
use Dashifen\WPHandler\Handlers\HandlerException;
use Dashifen\WPHandler\Hooks\Factory\HookFactoryInterface;
use Dashifen\WPHandler\Handlers\Plugins\AbstractPluginHandler;
use Dashifen\WPHandler\Hooks\Collection\Factory\HookCollectionFactoryInterface;

class ACFSharingSettings extends AbstractPluginHandler
{
    private bool $sharingIsSubPage = true;
    private string $sharingMenuName = 'Sharing and Analytics';
    private string $sharingMenuIcon = 'dashicons-share';
    private string $sharingMenuSlug = '';
    private int $sharingMenuPosition = 9;
    
    public function __construct (
        ?HookFactoryInterface $hookFactory = null,
        ?HookCollectionFactoryInterface $hookCollectionFactory = null
    ) {
        parent::__construct($hookFactory, $hookCollectionFactory);
        $this->sharingIsSubPage = apply_filters('acf-sharing-settings-use-submenu', $this->sharingIsSubPage);
        $this->sharingMenuName = apply_filters('acf-sharing-settings-menu-name', $this->sharingMenuName);
        $this->sharingMenuIcon = apply_filters('acf-sharing-settings-menu-icon', $this->sharingMenuIcon);
        $this->sharingMenuPosition = apply_filters('acf-sharing-settings-menu-position', $this->sharingMenuPosition);
        $this->sharingMenuSlug = 'acf-options-' . sanitize_title($this->sharingMenuName);
    }
    
    /**
     * initialize
     *
     * Uses addAction() and addFilter() to connect WordPress to the methods
     * of this object's child which are intended to be protected.
     *
     * @return void
     * @throws HandlerException
     */
    public function initialize (): void
    {
        if (!$this->isInitialized()) {
            $this->addAction('acf/init', 'addSharingSettingsPage');
            $this->addAction('acf/init', 'addSharingSettingsFields', 15);
            $this->addAction('acf/load_value/key=field_5b217fef91019', 'setDefaultSharingTitle');
            $this->addAction('admin_notices', 'notifyOnMissingSettings');
            $this->addAction('after_setup_theme', 'addImageSizes');
            $this->addAction('wp_head', 'emitSharingSettings');
            $this->addAction('wp_footer', 'emitAnalyticsSettings');
        }
    }
    
    /**
     * addOptionsPage
     *
     * Adds the options page to the Dashboard menu using the details passed
     * here from the initialization function above.
     *
     * @return void
     */
    protected function addSharingSettingsPage (): void
    {
        if ($this->withACF()) {
            $args = $this->sharingIsSubPage
                ? [
                    'page_title'  => $this->sharingMenuName,
                    'parent_slug' => 'options-general.php',
                    'capability'  => 'manage_options',
                ] : [
                    'page_title' => $this->sharingMenuName,
                    'icon_url'   => $this->sharingMenuIcon,
                    'position'   => $this->sharingMenuPosition,
                    'capability' => 'manage_options',
                ];
            
            acf_add_options_page($args);
        }
    }
    
    private function withACF (): bool
    {
        return function_exists('acf_add_options_page');
    }
    
    /**
     * addSharingSettingsFields
     *
     * Adds the actual ACF fields and field groups to the options page we
     * added above.  This PHP was generated with the ACF plugin.
     *
     * @return void
     */
    protected function addSharingSettingsFields ()
    {
        if ($this->withACF()) {
            acf_add_local_field_group([
                'key'                   => 'group_5b217fc6e5c3a',
                'title'                 => 'Social Networking and Analytics',
                'fields'                => [
                    [
                        'key'               => 'field_5b21814b34e06',
                        'label'             => 'General Fields',
                        'name'              => 'general',
                        'type'              => 'group',
                        'instructions'      => 'These fields are used on both Twitter and Facebook.',
                        'required'          => 1,
                        'conditional_logic' => 0,
                        'wrapper'           => [
                            'width' => '',
                            'class' => '',
                            'id'    => '',
                        ],
                        'layout'            => 'block',
                        'sub_fields'        => [
                            [
                                'key'               => 'field_5b217fef91019',
                                'label'             => 'Title',
                                'name'              => 'title',
                                'type'              => 'text',
                                'instructions'      => 'Enter the title of this site.',
                                'required'          => 0,
                                'conditional_logic' => 0,
                                'wrapper'           => [
                                    'width' => '',
                                    'class' => '',
                                    'id'    => '',
                                ],
                                'default_value'     => '',
                                'placeholder'       => '',
                                'prepend'           => '',
                                'append'            => '',
                                'maxlength'         => '',
                            ],
                            [
                                'key'               => 'field_5b21819634e07',
                                'label'             => 'Description',
                                'name'              => 'description',
                                'type'              => 'textarea',
                                'instructions'      => 'Enter one or two sentences about this site.',
                                'required'          => 0,
                                'conditional_logic' => 0,
                                'wrapper'           => [
                                    'width' => '',
                                    'class' => '',
                                    'id'    => '',
                                ],
                                'default_value'     => '',
                                'placeholder'       => '',
                                'maxlength'         => '',
                                'rows'              => 3,
                                'new_lines'         => '',
                            ],
                        ],
                    ],
                    [
                        'key'               => 'field_5b217fcf91018',
                        'label'             => 'Facebook Sharing',
                        'name'              => 'facebook',
                        'type'              => 'group',
                        'instructions'      => 'These fields determine how things look when your site is shared on Facebook.',
                        'required'          => 1,
                        'conditional_logic' => 0,
                        'wrapper'           => [
                            'width' => '',
                            'class' => '',
                            'id'    => '',
                        ],
                        'layout'            => 'block',
                        'sub_fields'        => [
                            [
                                'key'               => 'field_5b2180419101b',
                                'label'             => 'Image',
                                'name'              => 'image',
                                'type'              => 'image',
                                'instructions'      => 'Images must be exactly 1200 pixels wide and 630 pixels high.',
                                'required'          => 0,
                                'conditional_logic' => 0,
                                'wrapper'           => [
                                    'width' => '',
                                    'class' => '',
                                    'id'    => '',
                                ],
                                'return_format'     => 'id',
                                'preview_size'      => 'thumbnail',
                                'library'           => 'all',
                                'min_width'         => 1200,
                                'min_height'        => 630,
                                'min_size'          => '',
                                'max_width'         => 1200,
                                'max_height'        => 630,
                                'max_size'          => '',
                                'mime_types'        => '',
                            ],
                        ],
                    ],
                    [
                        'key'               => 'field_5b2180d034e03',
                        'label'             => 'Twitter Sharing',
                        'name'              => 'twitter',
                        'type'              => 'group',
                        'instructions'      => 'These fields determine how things look when your site is shared on Twitter.',
                        'required'          => 1,
                        'conditional_logic' => 0,
                        'wrapper'           => [
                            'width' => '',
                            'class' => '',
                            'id'    => '',
                        ],
                        'layout'            => 'block',
                        'sub_fields'        => [
                            [
                                'key'               => 'field_5b2180f434e04',
                                'label'             => 'Twitter Handle',
                                'name'              => 'handle',
                                'type'              => 'text',
                                'instructions'      => 'Enter the handle for the Twitter account associated with this site.',
                                'required'          => 0,
                                'conditional_logic' => 0,
                                'wrapper'           => [
                                    'width' => '',
                                    'class' => '',
                                    'id'    => '',
                                ],
                                'default_value'     => '',
                                'placeholder'       => '',
                                'prepend'           => '@',
                                'append'            => '',
                                'maxlength'         => '',
                            ],
                            [
                                'key'               => 'field_5b2181d134e08',
                                'label'             => 'Image',
                                'name'              => 'image',
                                'type'              => 'image',
                                'instructions'      => 'Images must be exactly 1200 pixels wide and 675 pixels high.',
                                'required'          => 0,
                                'conditional_logic' => 0,
                                'wrapper'           => [
                                    'width' => '',
                                    'class' => '',
                                    'id'    => '',
                                ],
                                'return_format'     => 'id',
                                'preview_size'      => 'thumbnail',
                                'library'           => 'all',
                                'min_width'         => 1200,
                                'min_height'        => 675,
                                'min_size'          => '',
                                'max_width'         => 1200,
                                'max_height'        => 675,
                                'max_size'          => '',
                                'mime_types'        => '',
                            ],
                        ],
                    ],
                    [
                        'key'               => 'field_5b2180129101a',
                        'label'             => 'Google Analytics Code',
                        'name'              => 'analytics_id',
                        'type'              => 'text',
                        'instructions'      => 'Enter the "UA" code provided by Google for this site.',
                        'required'          => 1,
                        'conditional_logic' => 0,
                        'wrapper'           => [
                            'width' => '',
                            'class' => '',
                            'id'    => '',
                        ],
                        'default_value'     => '',
                        'placeholder'       => '',
                        'prepend'           => 'UA-',
                        'append'            => '',
                        'maxlength'         => '',
                    ],
                ],
                'location'              => [
                    [
                        [
                            'param'    => 'options_page',
                            'operator' => '==',
                            'value'    => $this->sharingMenuSlug,
                        ],
                    ],
                ],
                'menu_order'            => 0,
                'position'              => 'normal',
                'style'                 => 'default',
                'label_placement'       => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen'        => '',
                'active'                => 1,
                'description'           => '',
            ]);
        }
    }
    
    /**
     * setDefaultSharingTitle
     *
     * Returns the site's name when the value passed here is empty.  If it's
     * not empty, then it's something the visitor entered into the field last
     * time and we don't want to mess with it.
     *
     * @param string $value
     *
     * @return string
     */
    protected function setDefaultSharingTitle (string $value): string
    {
        if (!empty($value)) {
            $value = get_bloginfo('name');
        }
        
        return $value;
    }
    
    /**
     * notifyOnMissingData
     *
     * Sets an admin notice when the sharing and analytics information is
     * not available.
     *
     * @return void
     */
    protected function notifyOnMissingSettings (): void
    {
        if ($this->withACF()) {
            $allData = array_merge(
                $this->getSharingSettings(),
                $this->getAnalyticsSettings()
            );
            
            if ($this->isDataMissing($allData)) {
                /** @noinspection HtmlUnknownTarget */
                
                $link = sprintf('<a href="%s">%s</a>',
                    admin_url('admin.php?page=' . $this->sharingMenuSlug),
                    $this->sharingMenuName); ?>

              <div class='notice notice-error'>
                <p>Please fully complete the <?= $link ?> information
                  before launching this site.</p>
              </div>
            
            <?php }
        }
    }
    
    /**
     * getSharingData
     *
     * Returns a structured array of sharing data based on the ACFs defined
     * above.  Notice that the general title and description are included
     * twice, once for each network.
     *
     * @return array
     */
    protected function getSharingSettings (): array
    {
        if ($this->withACF()) {
            $generalTitle = $this->getTitle();
            $generalDescription = $this->getDescription();
            $twitterHandle = $this->getTwitterHandle();
            
            return [
                'facebook' => [
                    'url'         => get_home_url(),
                    'title'       => $generalTitle,
                    'description' => $generalDescription,
                    'image'       => $this->getImageSrC('facebook'),
                ],
                
                'twitter' => [
                    'site'        => $twitterHandle,
                    'title'       => $generalTitle,
                    'description' => $generalDescription,
                    'image'       => $this->getImageSrc('twitter'),
                ],
            ];
        }
        
        return [];
    }
    
    /**
     * getTitle
     *
     * Returns the sharing title, using the default title specified in the
     * settings for the home and front page and the post's title otherwise.
     *
     * @return string
     */
    protected function getTitle (): string
    {
        return is_home() || is_front_page() || empty($title = get_the_title())
            ? get_field('general_title', 'option')
            : $title;
    }
    
    protected function getDescription (): string
    {
        if (is_home() || is_front_page()) {
            return get_field('general_description', 'option');
        }
        
        // if we didn't return above, then we want to use the content of our
        // post to extract the first two sentences and use those as our
        // description.  to do that we split based on a regular expression that
        // looks for punctuation followed by spaces and a capital letter.  this
        // helps to avoid abbreviations.
        
        $post = get_post();
        $content = apply_filters('the_content', $post->post_content);
        $sentences = preg_split('/\. +[A-Z]/', $content);
        
        if (sizeof($sentences) === 0) {
            return get_field('general_description', 'option');
        }
        
        // because the size of our array is not zero, we know there must be at
        // least one sentence in it.  so we'll use that one and then add the
        // second sentence to it.  but, in case there was only one sentence
        // available, we'll use the null coalescing operator to avoid a PHP
        // warning.
        
        return $sentences[0] . ' ' . ($sentences[1] ?? '');
    }
    
    /**
     * getTwitterHandle
     *
     * Returns the twitter handle for this site ensuring that it begins with
     * the @-symbol.
     *
     * @return string
     */
    protected function getTwitterHandle (): string
    {
        if ($this->withACF()) {
            $twitterHandle = get_field('twitter_handle', 'option');
            
            if (substr($twitterHandle, 0, 1) !== '@') {
                $twitterHandle = '@' . $twitterHandle;
            }
        }
        
        return $twitterHandle ?? '';
    }
    
    /**
     * getImageSrc
     *
     * Given the social network we care about at this time, return the
     * image that we're to use when this site is shared on it.
     *
     * @param string $network
     *
     * @return string
     */
    protected function getImageSrc (string $network): string
    {
        // we want to use the featured image for this post, if it's available,
        // and fall back on the default image when we need to.
        
        if (has_post_thumbnail()) {
            $imageSrc = wp_get_attachment_image_src(get_post_thumbnail_id(), $network . '-card')[0];
        } else {
            $imageId = get_field($network . '_image', 'option');
            $imageSrc = wp_get_attachment_image_src($imageId, $network . '-card')[0];
        }
        
        return $imageSrc ?? '';
    }
    
    /**
     * getAnalyticsData
     *
     * Returns the information about analytics based on the ACFs above.
     *
     * @return array
     */
    protected function getAnalyticsSettings (): array
    {
        if ($this->withACF()) {
            $uaId = strtoupper(get_field('analytics_id', 'option'));
            
            if (substr($uaId, 0, 3) !== 'UA-') {
                $uaId = 'UA-' . $uaId;
            }
            
            return [
                'google' => [
                    'analytics' => $uaId
                ]
            ];
        }
        
        return [];
    }
    
    /**
     * isDataMissing
     *
     * Given an array, returns true if everything in it is empty.
     *
     * @param array $array
     *
     * @return bool
     */
    protected function isDataMissing (array $array): bool
    {
        
        // ACF should make sure that our data is complete -- i.e. it's all
        // required in the field group.  but, we're going to check for it all
        // here just in case.  to do that, we're going to flatten the array
        // (source: https://stackoverflow.com/a/1320156/360838) and then loop
        // through it.  the first empty value we find, we return true.
        
        $flatArray = $this->array_flatten($array);
        
        foreach ($flatArray as $value) {
            if (empty($value)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * array_flatten
     *
     * Turns a multi-dimensional array into a single-dimensional one
     * containing all the values within the original.
     *
     * @param $array
     *
     * @return array
     */
    protected function array_flatten (array $array): array
    {
        $flatArray = [];
        
        array_walk_recursive($array,
            function ($value) use (&$flatArray) {
                
                // the array_walk_recursive() function means that each $value
                // within the non-flat $array ends up here.  we trim them all
                // and then add them to $flatArray.
                
                $flatArray[] = trim($value);
            });
        
        return $flatArray;
    }
    
    /**
     * addImageSizes
     *
     * Adds image sizes for Facebook and Twitter so that we can use featured
     * images as a part of the social media cards.
     *
     * @return void
     */
    protected function addImageSizes (): void
    {
        add_image_size('twitter-card', 1200, 675);
        add_image_size('facebook-card', 1200, 630);
    }
    
    /**
     * emitSettings
     *
     * Emits the sharing settings information collected by this plugin in the
     * <head> of the site.
     *
     * @return void
     */
    protected function emitSharingSettings (): void
    {
        $this->renderTwig($this->getSharingSettings(), 'sharing.twig');
    }
    
    /**
     * renderTwig
     *
     * If the $context is not empty (using the above method to determine
     * emptiness) then we render the twig.
     *
     * @param array  $context
     * @param string $twig
     *
     * @return void
     */
    private function renderTwig (array $context, string $twig): void
    {
        if (!$this->isDataMissing($context)) {
            $twigFile = realpath(__DIR__ . '/../assets/' . $twig);
            Timber::render($twigFile, $context);
        }
    }
    
    /**
     * emitAnalyticsSettings
     *
     * Emits the analytics settings information collected by this plugin just
     * before the closing </body> tag of the site.
     *
     */
    protected function emitAnalyticsSettings (): void
    {
        $this->renderTwig($this->getAnalyticsSettings(), 'analytics.twig');
    }
}
