(function ($) {
  $(document).ready(function(){
    //  Navigation DropDown
    createDropDownNav($("#block-menu-block-1 .menu-block-wrapper"));

    // Target fitvids
    $(".field-name-field-featured-video").fitVids();
  }); // END document.ready

  function createDropDownNav(menu) {
    /* Get the window's width, and check whether it is narrower than 480 pixels */
    //var windowWidth = $(window).width();
    //if (windowWidth <= 480) {

       /* Clone our navigation */
       var mainNavigation = menu.clone();

       /* Replace unordered list with a "select" element to be populated with options, and create a variable to select our new empty option menu */
       menu.append('<select class="menu" id="navigation-dropdown"></select>');
       var selectMenu = $('select.menu');

       $(selectMenu).append('<option value="" selected="selected">Go To…</option>');
       //$(selectMenu).append('<option value="/">Home</option>');

       /* Navigate our nav clone for information needed to populate options */
       $(mainNavigation).children('ul').children('li').each(function() {

          /* Get top-level link and text */
          var href = $(this).children('a').attr('href');
          var text = $(this).children('a').text();

          /* Append this option to our "select" */
          if(text != "Home"){
            $(selectMenu).append('<option value="'+href+'">'+text+'</option>');
          }

          /* Check for "children" and navigate for more options if they exist */
          if ($(this).children('ul').length > 0) {
             $(this).children('ul').children('li').each(function() {

                /* Get child-level link and text */
                var href2 = $(this).children('a').attr('href');
                var text2 = $(this).children('a').text();

                /* Append this option to our "select" */
                $(selectMenu).append('<option value="'+href2+'">--- '+text2+'</option>');
             });
          }
       });
    //}
	
	/* Enable JQuery UI accordion */
	$('#accordion').accordion();

    /* When our select menu is changed, change the window location to match the value of the selected option. */
    $(selectMenu).change(function() {
       location = this.options[this.selectedIndex].value;
    });
	
	/* Custom JS for NAP project page */
  	  var pageHeight = $('#main .page-width').height();
  	  $('#sidebar-first').height(pageHeight);

      /* Init jquery tabs on groups page */
      $('#contentTabsEnglish').tabs();
      $('#contentTabsFrench').tabs();

      $('.switch-language').click(function(event) {
          var data = $(this).data();
          $('.switch-language').removeClass('active');
          $(this).addClass('active');
          switch (data.language) {
              case 'english':
                  $('.contentTabs').removeClass('show');
                  $('#contentTabsEnglish').addClass('show');
                  break;
              case 'french':
                  $('.contentTabs').removeClass('show');
                  $('#contentTabsFrench').addClass('show');
          }
      });
  }

})(jQuery); //$