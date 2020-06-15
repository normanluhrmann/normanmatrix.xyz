# ChangeLog

## 2.3.6
* ADD: allow to open map marker popup by click on the listing item;
* UPD: allow to correctly get data from Posts relations in the form preset;
* UPD: new datetimepicker control for date time field;
* UPD: add separate controls for Geocoding API key in the Maps Listings module;
* FIX: ensure injection listing grid CSS rendered on AJAX requests;
* FIX: Crocoblock/suggestions#1143 on the frontend;
* FIX: an ability to edit another user's post through a Form with the `edit_others_posts` capability.

## 2.3.5
* FIX: new map markers options and JetSmartFilters compatibility.

## 2.3.4
* ADD: allow to set multiple map marker types by conditions;
* UPD: aligments controls in the Dynamic field widget;
* UPD: alignments controls in the Dynamic field widget;
* FIX: Crocoblock/suggestions#1149;
* FIX: Crocoblock/suggestions#1155;
* FIX: creating the Blocks listing item without active Elementor;
* FIX: prevetn PHP notice in the Custom Field Tag;
* FIX: Crocoblock/suggestions#1143;
* FIX: if all checkboxes unchecked, this meta value was not empty;
* FIX: prevent form layout break on form quick editing;
* FIX: injection listings conflict;
* FIX: prevent PHP notices from taxonomies manager.

## 2.3.3
* ADD: %queried_user_id% macros to get user ID at the author pages, profile builder user pages;
* UPD: allow to get address from multiple meta fields for Maps module;
* UPD: allow to set custom capability type for new taxonomies;
* FIX: correctly get data for queried user context in the User Field and User Image dynamic tags;
* FIX: capabilities check on term meta saving.

## 2.3.2
* UPD: allow to set post ID for meta fields in the shortcodes generator;
* FIX: allow to set empty value for select option in the meta fields;
* FIX: missing line breaks in meta after update from form WYSIWYG field;
* FIX: Crocoblock/suggestions#1123.

## 2.3.1
* UPD: allow to query posts by types and status in the dynamic function tag;
* UPD: ensure HTML attributes is correctly reset on form elements render;
* FIX: form styles;
* FIX: prevent PHP notices when saving built-in post types.

## 2.3.0
* ADD: Dynamic Function Tag for Elementor;
* ADD: Maps Listings;
* ADD: Repeater type meta fields display in the Listing Grid;
* ADD: Custom template creation for Checkbox and Radio meta fields within the Form’s functionality;
* ADD: An opportunity to add custom values to Radio and Checkbox meta fields types from the editing page of Post/ Taxonomy/ Options Page;
* ADD: New notification types for Forms: MailChimp and GetResponse;
* ADD: Crocoblock/suggestions#914;
* ADD: License check for updates;
* UPD: Forms module. Current Post Author Name & Current User Name values for hidden fields;
* UPD: Allow to change form pages on field value change;
* UPD: Media field type in the Forms functionality refined;
* UPD: Add with_front option for Post Type and Taxonomy edit screens;
* UPD: Allow to add custom query arguments to redirect URL in the form redirect notification;
* FIX: Crocoblock/suggestions#604;
* FIX: Dynamic bg for listing items;
* FIX: Prevent PHP notices in some cases;
* FIX: Various minor fixes.

## 2.2.7
* ADD: compatibility a Term Grid listing with JetPopup;
* UPD: allow to set top and bottom positions for dynamic link icon;
* UPD: allow to reset field appearance;
* UPD: checked values list callback re-factoring;
* UPD: parse the options list from meta field for the Form module;
* FIX: minor form style;
* FIX: Safari select compatibility;
* FIX: ensure listing grid CSS rendered on AJAX requests;
* FIX: missing line breaks in the meta field of the textarea after saving;
* FIX: calculating process if a checkbox has only one field;
* FIX: prevent fatal errors if maybe_set_current_object is called without some of required arguments.

## 2.2.6
* ADD: support for color dynamic tags category;

## 2.2.5
* ADD: support `Save as array` checkbox fields for user meta;
* UPD: allow to correctly setup relations with front-end forms;
* UPD: better RTL compatibility;
* UPD: better compatibility with Dynamic CSS;
* FIX: saving settings on the options page with specific access capability;
* FIX: https://github.com/Crocoblock/suggestions/issues/1008;
* FIX: layout option for checkbox and radio fields in the Form.

## 2.2.4
* FIX: prevent PHP error in the forms;
* FIX: missing dynamic BG properties for a elements inside a listings.

## 2.2.3
* FIX: Elementor 2.9 compatibility;
* FIX: prevent PHP error on archive templates;
* FIX: add User URL to allowed user fields;
* FIX: minor fixes.

## 2.2.2
* UPD: Show form when preset is configured but no source was found;
* FIX: Some issues related to nested listings;
* FIX: Required value for wysiwyg field;
* FIX: JetPopup compatibility;
* FIX: Profile menu on mobile devices;
* FIX: Dynamic bg for listing items.

## 2.2.1
* UPD: Form Module. Prevent form from display if current user haven't access to configured preset data;
* UPD: Form Module. Minor improvements for insert/update post notification;
* FIX: Form Module. Set post terms for checkbox field;
* FIX: Listings. Current object set up and reset for listing items.

## 2.2.0
* ADD: Profile Builder module;
* ADD: Allow to preset form values from post data, user data or query varaibles;
* ADD: Update User notification;
* ADD: Presets logic;
* ADD: Media field for from module;
* ADD: Range field for from module;
* ADD: Heading field for from module;
* ADD: Page breaks for form module;
* ADD: ActiveCampaign for form module;
* ADD: Relations hierarchy;
* ADD: Listing Grid block for Gutenberg editor;
* UPD: Allow to update posts for Insert*Update Posts notification;
* UPD: Minor updates of Meta Fields editor UI;
* UPD: Object properties selector now contains list of all avaialble properties of all sources;
* FIX: Various bug fixes and minor enhancements.

## 2.1.4
* FIX: parent/child options pages registration.

## 2.1.3
* FIX: re-initialize widgets scripts on Listing Grid load more click.

## 2.1.2
* FIX: multiday events display in Calendar widget;
* ADD: %current_meta_string% macros to correctly get stringified arrays from meta fields.

## 2.1.1
* FIX: equal columns height for Listing Grid widget;
* FIX: allow to keep hover effects with click-able listing grid items.

## 2.1.0
* ADD: Allow to make whole listing item clickable;
* ADD: Load More for Listing Grid widget;
* ADD: Allow to inject alternative listing items into listing grid;
* ADD: Allow to create meta fields for users;
* ADD: Allow to set default values for meta fields;
* ADD: Allow to create Listing items in Blocks (Gutenberg) editor;
* ADD: Allow to use multiple orderby;
* UPD: Allow to query posts by multiple pot types in Listing Grid;
* UPD: Allow to order posts by multiple meta clauses;
* UPD: Allow to set fallback values for Dynamic Field widget;
* UPD: Allow to add counter for items in Dynamic Repeater widget;
* FIX: Various fixes.

## 2.0.3
* ADD: Do Shortcode callback for Dynamic Field filters;
* FIX: Rewriting document type on listing item autosave in Elementor editor;

## 2.0.2
* FIX: Taxonomies meta fields registration;

## 2.0.1
* FIX: better WooCommerce + JetWooBuilder compatibility;
* FIX: Post types and taxonomies labels saving;
* FIX: Meta fields visibility in Elementor widgets controls.

## 2.0.0
* ADD: Admin UI/UX: new admin UI;
* ADD: Admin UI/UX: allow to edit built-in post types;
* ADD: Admin UI/UX: allow to delete/reattach created posts (terms) on post type (taxonomy deletion);
* ADD: Admin UI/UX: allow to change type of already created posts/terms on post type/taxonomy slug update;
* ADD: Admin UI/UX: allow to make admin columns sortable;
* ADD: Admin UI/UX: allow to select from predefined callbacks for admin columns;
* ADD: Admin UI/UX: allow to group created fields into tabs/accordions;
* ADD: Admin UI/UX: allow to set max length and required for created fields where is possible;
* ADD: New feature: global options pages;
* ADD: Listing Calendar: showcase multiday events;
* UPD: Admin UI/UX: allow to sort notifiactions in forms;
* UPD: Listing Calendar: allow to set default month;
* UPD: Elementor widgets: compatibility with new Elemntor icons control;
* UPD: Elementor widgets: show all existing fields in Elemntor widgets controls;
* UPD: Elementor widgets: added callback for filtering switcher meta fields;
* FIX: Prevent errors if some of dates in calendar posts is not timestamp;
* FIX: Posts control in repeater;
* FIX: Various fixes and performance improvements.

## 1.4.8
* FIX: Elementor Pro 2.6+ compatibility.

## 1.4.7
* FIX: Better ACF compatibility;
* ADD: JS trigger on From wdget init;
* ADD: PHP hooks to add own fields into forms builder.

## 1.4.6.1
* UPD: allow to use P tag in dynamic field widget;
* FIX: Elementor 2.6.x compatibility.

## 1.4.6
* FIX: Booking form fields render.

## 1.4.5
* ADD: Masonry layout for listing grid widget;
* FIX: Better ACF compaibility.

## 1.4.4
* ADD: `jet-engine/forms/booking/notifications/fields-after` hook;
* UPD: Allow to filter form field template path;
* UPD: Store inserted post ID into form data to allow process it by other notifications.

## 1.4.3
* FIX: Prevent errors in Listing grid widget;
* FIX: Macros regex.

## 1.4.2
* ADD: macros for related posts between two post types;
* ADD: reCAPTCHA v3 validation for booking forms;
* ADD: JetEngine gallery dynamic tag - https://github.com/CrocoBlock/suggestions/issues/120;
* ADD: Allow to add descriptions for meta fields - https://github.com/CrocoBlock/suggestions/issues/134;
* ADD: render_acf_checkbox filter for Dynamic Repeater widget items
* UPD: https://github.com/CrocoBlock/suggestions/issues/250;
* UPD: https://github.com/CrocoBlock/suggestions/issues/213;
* FIX: Fade animation for listing grid slider;
* FIX: htps://github.com/CrocoBlock/suggestions/issues/183;
* FIX: Prevent shrink `post` control;
* FIX: Prevent php error when `$elementor_data` is array;
* FIX: `grid-items` container width;
* FIX: prevent errors on posts with relations saving;
* FIX: Dynamic Link widget, Icon Gap option visibility.

## 1.4.1
* FIX: Date- and timepicker styles;
* FIX: Listing Grid slider behavior when found posts < number slides to show;
* FIX: Start of month and prev month dates calculations in Calendar widget;
* FIX: Better check for an empty results in Dynamic Field widget.

## 1.4.0
* ADD: `Register user` notification for booking form;
* ADD: `Call a Webhook` notification for booking form;
* ADD: `Field Visibility` option for Booking form fields;
* ADD: `Post status` option for Insert post notification in Booking form;
* ADD: Allow to use dynamic popups from JetPopup inside listing and calendar;
* ADD: Mobile settings for image gallery slider in Dynamic Field widget;
* ADD: Allow to set meta field width;
* UPD: Allow to showcase listing grid as slider;
* UPD: Allow to set equal columns height for listing grid widget;
* UPD: Cross-browser Date- and Timepicker for meta fields;
* FIX: Allow to use shortcode in Not Found Message control;
* FIX: Mobile columns in Listing Grid widget.

## 1.3.2
* ADD: Post status control for Listing Grid Widget;
* UPD: Gallery slider init for Dynamic Field widget;
* UPD: Move meta boxes registration to admin_init hook
* FIX: Better ACF compatibility;
* FIX: Timestamp validation for Format Date callback in Dynamic Field widget;
* FIX: Jet Smart Filters compatibility for Listing Grid Widget when archive query option enabled;
* FIX: Custom meta fields list in Dynamic Repeater Widget;

## 1.3.1
* ADD: 'Get post/page link (linked post title)' callback for Dynamic Field widget;

## 1.3.0
* ADD: Booking Forms functionality;
* FIX: %current_terms% macros processing for terms query;

## 1.2.6
* UPD: Responsive controls for gaps in Listing Grid widget;
* FIX: Better compatibility with JetSmartFilters;
* FIX: Processing datetime meta;

## 1.2.5
* ADD: Better WPML compatibility;
* UPD: Listing returns not found when using related posts macros and no related posts were found;
* FIX: Show in nav menu control for Post Types and Taxonomies;
* FIX: Make relations compatible with PODs;
* FIX: Prevent errors with Elementor 2.4.0;
* FIX: Customize field output in combination with Related posts list callback;
* FIX: Delimiter for checkboxes values

## 1.2.4
* ADD: Admin columns management;
* ADD: Text before and Text after controls for Dynamic terms widget;
* ADD: Allow to enable/disable link on term in Dynamic terms widget;
* ADD: 'queried_term' macros;
* FIX: months translation in Calendar grid widget

## 1.2.3
* ADD: RU localization

## 1.2.2
* ADD: rel and target controls to Dynamic Image link;
* ADD: allow to add meta boxes only for specific posts/pages;
* FIX: Checkbox meta fields processing.

## 1.2.1
* FIX: Allow to use HTML tags in textarea meta field;

## 1.2.0
* ADD: Calendar widget;
* ADD: Posts relationships;
* ADD: Columns gap for Listing Grid widget;
* ADD: 'QR Code' callback to filter Dynamic Field output;
* ADD: 'Format number' callback to filter Dynamic Field output;
* ADD: Date query controls for Posts query settings in Listing Grid widget;
* FIX: Dynamic image tag.

## 1.1.3

* ADD: 'Embed icon' callback for Filter field output option in Dynamic field widget;
* ADD: %current_terms% and %current_meta% macros;
* UPD: Allow to use shortcodes inside Field format control in Dynamic field widget;
* FIX: Prevent JavaScript errors in some cases;
* FIX: Correctly enqueue assets for multiple meta boxes on page.

## 1.1.2

* ADD: Allow to filter posts query arguments;
* ADD: 'Get value from query variable' control for Meta Query in Listing Grid Widget;
* ADD: Allow to use macros in Get terms of posts control in Listing grid widget;
* UPD: Prepare for JetSmartFilters plugin;
* FIX: Current object reset after listing.

## 1.1.1

* ADD: Listing Grid visibility options;
* FIX: Hook name for filtering macros and filters lists;
* FIX: Applying macros in Meta Query values.

## 1.1.0

* ADD: Allow to filter values in repeater items;
* ADD: Gallery meta field;
* ADD: %current_id%, %current_tags% and %current_categories% macros;
* ADD: WYSIWYG meta field;
* ADD: Slider and grid output for gallery meta field;
* ADD: New options for Dynamic Repeater widget;
* ADD: New opitons for Dynamic Link widget;
* ADD: Embed URL callback;
* ADD: Allow to use dynamic terms images on taxonomy archives;
* UPD: Allow to set and output multiple values for select field;
* FIX: Prevent errors on archive pages;
* FIX: Meta boxes registration;
* FIX: Meta fields parsing for dynamic widgets options.

## 1.0.0

* Initial release;

