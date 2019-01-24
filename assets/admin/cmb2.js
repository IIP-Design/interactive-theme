(function($) {
  $(document).on('cmb_init', function() {
    // Metabox DOM Selections
    var widgetMetabox = document.getElementById('inter_cb_box_cdp'),
      accordionMetaBox = document.getElementById('inter_cb_accordion'),
      buttonLinksMetabox = document.getElementById('inter_cb_button_links'),
      ctaMetabox = document.getElementById('inter_cb_cta'),
      eventListMetabox = document.getElementById('inter_cb_events_list'),
      filteredListMetaBox = document.getElementById('inter_cb_box_filter'),
      genericButtonMetabox = document.getElementById('inter_cb_box_btn'),
      mediaBlockMetabox = document.getElementById('inter_cb_media'),
      pageListMetabox = document.getElementById('inter_cb_pages_list'),
      socialMetabox = document.getElementById('inter_cb_social_links'),
      textBlockMetaBox = document.getElementById('inter_cb_text_block'),
      selectByContentType = $('.cdp-select-posts-by-content-type'),
      selectByTaxonomy = $('.cdp-select-posts-by-taxonomy'),
      selectByEventsNum = $('.cmb2-id-inter-num-events'),
      selectByIndividualEvents = $('.cmb2-id-cb-events-list-repeat-group'),
      selectByPostsCategory = $('.cmb2-id-inter-cdp-category'),
      selectByPostsTags = $('.cmb2-id-inter-cdp-tag'),
      selectByPostsNum = $('.cmb2-id-inter-num-events'),
      selectByPosts = $('.cmb-type-cdp-autocomplete.cmb-repeat'),
      selectByPostsLink = $('.cmb2-id-inter-cdp-autocomplete-related.cmb-repeat'),
      selectByPostsDisplay = $('.cmb2-id-inter-cdp-autocomplete-links-display'),
      languageFilterOption = $('input[value="language"]'),
      languageSelectionField = $('.cmb2-id-inter-cb-lang-selection'),
      cdpLanguageSelectionField = $('.cmb2-id-inter-cdp-select-language');

    // Metabox Object store for iterating
    var conditionalMetaboxes = {
      accordion: accordionMetaBox,
      button_links: buttonLinksMetabox,
      cta: ctaMetabox,
      event_list: eventListMetabox,
      filtered_list: filteredListMetaBox,
      media_block: mediaBlockMetabox,
      page_list: pageListMetabox,
      post_list: widgetMetabox,
      social: socialMetabox,
      text_block: textBlockMetaBox
    };


    function toggleConditionalMetaboxes(blockTypeSelection) {
      try {
        for (var type in conditionalMetaboxes) {
          if (type == blockTypeSelection) {
            conditionalMetaboxes[type].style.display = 'block';
            toggleGenericButtonDisplay(blockTypeSelection);
          } else {
            conditionalMetaboxes[type].style.display = 'none';
          }
        }
      } catch (err) {}
    }

    function hideAllConditionalMetaboxes() {
      try {
        for (var type in conditionalMetaboxes) {
          conditionalMetaboxes[type].style.display = 'none';
        }
      } catch (err) {}
    }

    function toggleGenericButtonDisplay(blockTypeSelection) {
      if( blockTypeSelection === 'cta' || blockTypeSelection === 'button_links' ) {
        genericButtonMetabox.style.display = 'none';
      } else {
        genericButtonMetabox.style.display = 'block';
      }
    }

    // Hide Conditional Boxes based on initial content type selection
    var init_content_type_selection = $("#inter_cb_type").val();
    if( init_content_type_selection === undefined ) {
      return;
    }

    if (conditionalMetaboxes[init_content_type_selection] !== undefined) {
      toggleConditionalMetaboxes(init_content_type_selection);
    } else {
      hideAllConditionalMetaboxes();
    }

    // Toggle Metabox display on content type selection
    /* eslint-disable no-console */
    $('#inter_cb_type').change(function() {
      var blockTypeSelection = $(this).val();

      console.log('blockTypeSelection: ', blockTypeSelection);
      console.log('**** Meta Object ****');
      console.log(conditionalMetaboxes[blockTypeSelection]);
      console.log('**********************');

      try {
        // Check if selection exists in metabox store object & toggle display || hide all conditional metaboxes
        if (conditionalMetaboxes[blockTypeSelection] !== undefined) {
          toggleConditionalMetaboxes(blockTypeSelection);
        } else {
          hideAllConditionalMetaboxes();
        }
      } catch (e) {
        console.log('Unable to update the view');
      }
    });
    /* eslint-enable no-console */
    
    // Set initial state of post list selection type within the Post List meta box
    var select = $('.cdp-select-posts-by input[type=radio]:checked').val();
    togglePostListFields( select );

    // Set initial state of event list selection type within the Event List meta box
    var selectEvents = $('.select-events-by input[type=radio]:checked').val();
    toggleEventListFields( selectEvents );

    // Set initial state of taxonomy selection within the Post List meta box
    var selectTax = $('.cdp-select-posts-by-taxonomy input[type=radio]:checked').val();
    toggleTaxonomyFields( selectTax );

    // Set initial state of language selection within the Post List Filters meta box
    toggleLanguageSelectionField( languageFilterOption );

    // Toggle post list selection type (by recent or custom) when selection is changed
    $('.cdp-select-posts-by input[type=radio]').change(function() {
      var selectBy = $(this).val();
      togglePostListFields( selectBy );
    });

    // Toggle event list selection type (by recent or custom) when selection is changed
    $('.select-events-by input[type=radio]').change(function() {
      var selectBy = $(this).val();
      toggleEventListFields( selectBy );
    });

    // Toggle taxonomy selection when selection is changed
    $('.cdp-select-posts-by-taxonomy input[type=radio]').change(function() {
      var selectBy = $(this).val();
      toggleTaxonomyFields( selectBy );
    });

    // Toggle language selection when language filter option is (un)checked
    languageFilterOption.change(function() {
      toggleLanguageSelectionField( this );
    });

    /**
     *
     * @param {string} selectBy  how will posts be queried, either by most recent or by individual post selections
     */
    function togglePostListFields( selectBy ) {
      if (selectBy === 'custom') {
        selectByPostsNum.hide();
        selectByContentType.hide();
        selectByTaxonomy.hide();
        cdpLanguageSelectionField.hide();
        selectByPosts.show();
        selectByPostsLink.show();
        selectByPostsDisplay.show();
      } else {
        selectByPostsNum.show();
        selectByContentType.show();
        cdpLanguageSelectionField.show();
        selectByTaxonomy.show();
        selectByPosts.hide();
        selectByPostsLink.hide();
        selectByPostsDisplay.hide();
      }
    }

    /**
     *
     * @param {string} selectBy  how will posts be queried, either by most recent or by individual post selections
     */
    function toggleEventListFields( selectBy ) {
      if (selectBy === 'custom') {
        selectByEventsNum.hide();
        selectByIndividualEvents.show();
      } else {
        selectByEventsNum.show();
        selectByIndividualEvents.hide();
      }
    }

    function toggleTaxonomyFields( taxonomy ) {
      switch (taxonomy) {
      case 'category':
        selectByPostsCategory.show();
        selectByPostsTags.hide();
        break;

      case 'tag':
        selectByPostsCategory.hide();
        selectByPostsTags.show();
        break;

      default:
        selectByPostsCategory.hide();
        selectByPostsTags.hide();
      }
    }

    function toggleLanguageSelectionField( element ) {
      const isChecked = $(element).prop('checked');
      if (isChecked) {
        languageSelectionField.fadeIn();
      } else {
        languageSelectionField.hide();
      }
    }

    /** @todo toggle bind related links to its correpsonding post
     * Add a corresponding link chooser if a post autocomplete field is added
     */
    // $('.cmb2-id-inter-cdp-autocomplete').on('cmb2_add_row', function(e) {
    //   var selector = $(
    //     'button[data-selector="inter_cdp_autocomplete_links_repeat"]'
    //   );
    //   if (selector) {
    //     selector.trigger('click');
    //   }
    // });

    // /**
    //  * Delete the corresponding link picker if a post autocomplete is deleted
    //  */
    // $('.cmb2-id-inter-cdp-autocomplete').on('click', function(e) {
    //   if (e.target.className === 'button-secondary cmb-remove-row-button') {
    //     var removeBtn = $(e.target);

    //     if (removeBtn instanceof jQuery) {
    //       // get the list of external post links (likn_picker cmb2 fields)
    //       var links = $(
    //         '.cmb2-id-inter-cdp-autocomplete-links.cmb-repeat .cmb-repeat-row'
    //       );

    //       // get the index position of the autocomplete post field row that contains the button
    //       // so the corresponding index in the links list can also be removed
    //       var index = removeBtn.closest('div.cmb-repeat-row').index();

    //       // if corresponding link picker row is found, then remove
    //       if ( index !== -1) {
    //         $(links[index]).remove();
    //       }
    //     }
    //   }
    // });

  });
})(jQuery);
