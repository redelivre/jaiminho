(function() {
     /* Register the buttons */
     tinymce.create('tinymce.plugins.MyButtons', {
          init : function(ed, url) {
               /**
               * Inserts shortcode content
               */
               ed.addButton( 'button_eek', {
                    title : 'Insert shortcode',
                    image : '../wp-includes/images/smilies/icon_eek.gif',
                    onclick : function() {
                         ed.selection.setContent('[myshortcode]');
                    }
               });
               /**
               * Inserts shortcode content
               */
               ed.addButton( 'button_addlink', {
                    title : 'Insert HTML',
                    image : '../wp-includes/images/smilies/icon_eek.gif',
                    onclick : function() {
                      jQuery('#jaiminho-helper').modal('show');
                      jQuery('#jaiminho-helper').on('shown.bs.modal', function () {
                          jQuery('#external_url').focus();
                          jQuery('#external_url_save').click(
                            function(){
                              //console.log(my_plugin.url+"?action=gethtml&url="+jQuery('#external_url').val());
                                jQuery.ajax({
                                  type: 'GET',
                                  cache: false,
                                  url: my_plugin.url,
                                  data: {action: "gethtml",url:jQuery('#external_url').val()},
                                  success: function(data){
                                  ed.execCommand('mceInsertContent', 0, data);
                                  }
                              });
                              jQuery('#jaiminho-helper').modal('hide');
                            }
                          );
                      });
                    }
               });
               /**
               * Adds HTML tag to selected content
               */
               ed.addButton( 'button_green', {
                    title : 'Add span',
                    image : '../wp-includes/images/smilies/icon_mrgreen.gif',
                    cmd: 'button_green_cmd'
               });
               ed.addCommand( 'button_green_cmd', function() {
                    var selected_text = ed.selection.getContent();
                    var return_text = '';
                    return_text = '<h1>' + selected_text + '</h1>';
                    ed.execCommand('mceInsertContent', 0, return_text);
               });
          },
          createControl : function(n, cm) {
               return null;
          },
     });
     /* Start the buttons */

     tinymce.PluginManager.add( 'my_button_script', tinymce.plugins.MyButtons );
})();
