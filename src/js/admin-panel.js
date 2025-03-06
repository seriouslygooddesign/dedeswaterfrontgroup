import "../scss/base/admin-panel/_admin-panel.scss";

//Wysiwyg Editor Autoheight
(function ($) {
  $(document).ready(function () {
    acf.add_filter?.("wysiwyg_tinymce_settings", function (mceInit, id, $field) {
      mceInit.wp_autoresize_on = true;
      return mceInit;
    });
    acf.add_action?.("wysiwyg_tinymce_init", function (ed, id, mceInit, $field) {
      ed.settings.autoresize_min_height = 200;
      $(".acf-editor-wrap iframe").css("height", "210px");
    });
  });
})(jQuery);
