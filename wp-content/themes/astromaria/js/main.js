(function($) {
  $(document).ready(function() {
    const SEARCH = $('.header__search');
    const SEARCH_FORM = $('.search');
    const SEARCH_TABS = $('.searchpage__tab');
    const SEARCH_ITEMS = $('.articles__item');

    $(SEARCH).on('click', function() {
      $(SEARCH_FORM).addClass('search--active');
    });

    $(SEARCH_FORM).on('click', function(e) {
      if (e.target === this) {
        $(this).removeClass('search--active');
      }
    });

    SEARCH_TABS.on('click', function() {
      const CATEGORY = $(this).data('category');

      SEARCH_TABS.removeClass('searchpage__tab--active');
      $(this).addClass('searchpage__tab--active');

      SEARCH_ITEMS.each(function() {
        const ITEM_CATEGORY = $(this).data('category');

        if (CATEGORY === 'all' || ITEM_CATEGORY === CATEGORY) {
          $(this).show();
        }
        else {
          $(this).hide();
        }
      });
    });
  });
}(jQuery));