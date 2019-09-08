<?php

function load_sticky_nav_menu($atts) {
  extract(shortcode_atts([
    'layout' => 'button-bottom',
    'titles' => '',
    'cta_text' => 'Take the next step!',
    'cta_btn_text' => 'Request a Demo',
    'cta_url' => ''
  ], $atts));
	
  $titles = vc_param_group_parse_atts($atts['titles']);

  ob_start(); ?>
  <style>

    .sticky-nav-wrapper {
      display: none;
    }

    .sticky-nav-wrapper ul,
    .sticky-nav-wrapper-mobile ul {
      margin: 0 0 30px 0;
    }

    .sticky-nav-wrapper li,
    .sticky-nav-wrapper-mobile li {
      list-style-type: none;
    }

    .kochava-button-green {
      margin-top: 12px;
      margin-bottom: 12px;
    }

    /* Mobile Styles */
    .sticky-nav-wrapper-mobile {
      position: fixed;
      top: 0;
      width: 100%;
      left: 0;
      background: #292929;
      color: #fff;
      padding: 15px;
      opacity: 0;
      box-shadow: 0px 1px 8px rgba(0, 0, 0, .2);
      z-index: 20;
      transform: translateY(-1000px);
	  visibility: visible;
    }

    .sticky-nav-wrapper-mobile ul a:hover {
      display: inline-block;
      padding: 0 15px;
      background: #3a3a3a;
    }

    .sticky-nav-wrapper-mobile ul a {
      color: #fff;
      padding: 0 15px;
    }

    .sticky-nav-wrapper-mobile .kochava-button-green,
    .sticky-nav-wrapper-mobile h4 {
      margin-left: 15px;
      color: #fff !important;
    }

    .sticky-nav-mobile-click {
      position: fixed;
      top: 0;
      width: 100%;
      left: 0;
      background: #292929;
      color: #fff;
      text-align: right;
      padding-right: 14px;
      z-index: 20;
      margin-bottom: 0 !important;
      opacity: 0;
      transform: none;
      transition: all .2s ease;
    }

    .sticky-nav-mobile-click.active {
      opacity: 1;
      transition: all .2s ease;
    }

    #sticky-nav-mobile-icon {
      background: transparent;
      font-size: 13px;
      transform: translateY(0);
      transition: all .3s ease;
    }

    #sticky-nav-mobile-icon.active {
      transform: rotate(180deg);
    }

    @media (min-width: 690px) {
      .sticky-nav-mobile-click {
        padding-right: 23px;
      }
    }

    @media (min-width: 1000px) {
      .sticky-nav-wrapper {
        display: block;
      }

      .sticky-nav-wrapper-mobile {
        display: none;
      }

      .sticky-nav-mobile-click {
        display: none;
      }
    }
  </style>

  <?php if ($layout === 'button-top') { ?>

  <div id="sticky-nav-<?php echo get_the_ID(); ?>" class="sticky-nav-wrapper">
    <h4><?php echo $cta_text; ?></h4>
    <a style="margin-bottom: 20px;" class="kochava-button-green" href="<?php echo $cta_url; ?>" target="_blank"><?php echo $cta_btn_text; ?></a>
    <ul>
      <?php
      foreach ($titles as $key => $value) {
        echo $value = '<li><a href=' . $value['url'] . ' target=' . $value['new_tab'] . '>' . $value['title'] . '</a></li>';
      }
      ?>
    </ul>
  </div>

<?php } else { ?>

  <div id="stick-nav-<?php echo get_the_ID(); ?>" class="sticky-nav-wrapper">
    <ul>
      <?php
      foreach ($titles as $key => $value) {
        echo $value = '<li><a href=' . $value['url'] . ' target=' . $value['new_tab'] . '>' . $value['title'] . '</a></li>';
      }
      ?>
    </ul>
    <h4><?php echo $cta_text; ?></h4>
    <a class="kochava-button-green" href="<?php echo $cta_url; ?>" target="_blank"><?php echo $cta_btn_text; ?></a>
  </div>

<?php } ?>

  <!-- Mobile Menu Template -->
  <div class="sticky-nav-mobile-click"><i id="sticky-nav-mobile-icon" class="icon-angle-down"></i></div>
  <div id="stick-nav-mobile-<?php echo get_the_ID(); ?>" class="sticky-nav-wrapper-mobile">
    <ul>
      <?php
      foreach ($titles as $key => $value) {
        echo $value = '<li><a href=' . $value['url'] . ' target=' . $value['new_tab'] . '>' . $value['title'] . '</a></li>';
      }
      ?>
    </ul>
    <h4><?php echo $cta_text; ?></h4>
    <a class="kochava-button-green" href="<?php echo $cta_url; ?>" target="_blank"><?php echo $cta_btn_text; ?></a>
  </div>

  <script>
    jQuery(document).ready(function($) {
      /* Selectors */
      var $wpadmin = $('#wpadminbar')
      var $window = $(window)
      var $stickyNavWrapper = $('.sticky-nav-wrapper')
      var $stickyParentRow = $stickyNavWrapper.parents('.wpb_row')
      var $stickyNavMobileClick = $('.sticky-nav-mobile-click')
      var $stickyNavMobileWrapper = $('.sticky-nav-wrapper-mobile')
      var $stickyNavMobileIcon = $('#sticky-nav-mobile-icon')

      /* Getters, Setters and Calcs */
      var $navHeight = $('#header-outer').outerHeight()
      var stickyParentHeight = $stickyParentRow.outerHeight()
      var stickyNavWrapperHeight = $stickyNavWrapper.outerHeight()
      var stickyParentRowPadding = parseFloat($stickyParentRow.css('padding-top'))
      var stickyNavMobileHeight = $('.sticky-nav-wrapper-mobile').outerHeight()
      var stickyNavMobileClickHeight = $('.sticky-nav-mobile-click').outerHeight()
      var offsetCalc = getPageheaderOffset()
      var $wpadminHeight = 0

      /** Get pageheader offset to set sticky */
      function getPageheaderOffset() {
        var offset = $stickyNavWrapper.parents('.wpb_column').offset()
        return offset.top - (getNavHeight() + stickyParentRowPadding)
      }

      /** NavHeight getter to update depending on watcher */
      function getNavHeight() {
		if($wpadmin.length > 0) {
			$wpadminHeight = $wpadmin.height()
			$navHeight = $wpadminHeight + $('#header-outer').outerHeight()
			return $navHeight
		} else {
			return $('#header-outer').outerHeight()
		}
      }

      /** Calculates sticky in relation to header and row padding */
      function calcSticky() {
        return getNavHeight() + stickyParentRowPadding
      }

      /** Calculate scroll to engage menu to stick to bottom of element */
      function bottomSticky() {
        return navMobileSticky() + stickyParentHeight - stickyNavWrapperHeight - stickyParentRowPadding
      }

      /** Page Header Height for Mobile, Salient page header or custom header */
      function navMobileSticky() {
        var pageHeader = $('#page-header-wrap')
        var topLevel = $('.wpb_row.top-level')
        var pageHeaderHeight
        if (pageHeader.length > 0) {
          pageHeaderHeight = pageHeader.outerHeight()
        }
        if (topLevel.length > 0) {
          pageHeaderHeight = topLevel.outerHeight()
        }
        return pageHeaderHeight
      }

      /** Mobile sticky nav menu on load */
      var isOpen = false //set toggle of mobile open/close
      $stickyNavMobileWrapper.css({
        top: (getNavHeight() + $stickyNavMobileClick.outerHeight()) + 'px'
      })

      /** icon animation */
      $stickyNavMobileClick.on('click', function() {
        isOpen = !isOpen
        if (isOpen) {
          $stickyNavMobileWrapper.css({
            transition: 'transform .4s ease, opacity .4s ease .25s, visibility .4s ease',
            opacity: 1,
            transform: 'translateY(0)',
			visibility: 'visible'
          })
          $stickyNavMobileIcon.addClass('active')
		  $('.wpb_row > .span_12').css({
			zIndex: 'initial' 
		  })
        }
        else {
          $stickyNavMobileWrapper.css({
            transition: 'transform .4s ease .3s, opacity .4s ease, visibility .4s ease',
            opacity: 0,
            transform: 'translateY(-' + (stickyNavMobileHeight + stickyNavMobileClickHeight) + 'px)',
			visibility: 'hidden'
          })
          $stickyNavMobileIcon.removeClass('active')
		  $('.wpb_row > .span_12').css({
			zIndex: '10' 
		  })
        }
      })

      /** Menu close on link click */
      $stickyNavMobileWrapper.find('a').on('click', function() {
        isOpen = false
        $stickyNavMobileWrapper.css({
          transform: 'translateY(-' + (stickyNavMobileHeight + stickyNavMobileClickHeight) + 'px)'
        })
        $stickyNavMobileIcon.removeClass('active')
      })

      /* watch scroll postion */
      $window.on('scroll resize', function() {
        /** Set sticky nav location to below header Desktop */
        if ($window.scrollTop() <= getPageheaderOffset() && $window.outerWidth() > 1000) {
          $stickyNavWrapper.css({
            position: 'static',
            transform: 'translateY(0)'
          })
        }
        else if ($window.scrollTop() >= getPageheaderOffset() && $window.outerWidth() > 1000) {
          $stickyNavWrapper.css({
            position: 'fixed',
            top: 0,
            transform: 'translateY(' + calcSticky() + 'px )',
            marginBottom: 'auto'
          })
        }
        else {
          $stickyNavWrapper.css({
            position: 'static',
            transform: 'translateY(0)'
          })
        }

        /* threshold for stickynav to stick to bottom */
        if ($window.scrollTop() >= bottomSticky() && $window.outerWidth() > 1000) {
          $stickyNavWrapper.css({
            position: 'absolute',
            transform: 'translateY(0)',
            top: 'auto',
            bottom: 0,
            marginBottom: 0
          })
        }

        /* engage mobile sticky nav */
        if ($window.scrollTop() >= navMobileSticky()) {
          $stickyNavMobileClick.css({
			transition: 'all .2s ease',
            transform: 'translateY(' + (getNavHeight()) + 'px)'
          })
          $stickyNavMobileWrapper.css({
            top: (getNavHeight() + $stickyNavMobileClick.outerHeight()) + 'px'
          })
          $stickyNavMobileClick.addClass('active')
        }
        else {
          $stickyNavMobileClick.css({
            transition: 'all .6s ease',
            transform: 'translateY(0)'
          })
          $stickyNavMobileClick.removeClass('active')
		  
		  /** handle close menu when menu click hides */
		  setTimeout(function(){
			isOpen = false
		  	$stickyNavMobileIcon.removeClass('active')
		  },500)
		  	 
		  $stickyNavMobileWrapper.css({
			visibility: 'hidden',
            transition: 'transform .4s ease .5s, opacity 0s ease, visibility 0s ease',
            opacity: 0,
            transform: 'translateY(-' + (stickyNavMobileHeight + stickyNavMobileClickHeight) + 'px)'
          })
          
		  $('.wpb_row > .span_12').css({
			zIndex: '10' 
		  }) 		  
        }
      })
    })

  </script>

  <?php
  $sticky_menu = ob_get_contents();
  ob_end_clean();
  return $sticky_menu;
}

add_shortcode('sticky_nav_menu', 'load_sticky_nav_menu');

?>
