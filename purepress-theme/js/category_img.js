jQuery(document).ready(function($){
   var custom_uploader;
   $('#upload_image_button').click(function(e) {
     e.preventDefault();
     if (custom_uploader) {
       custom_uploader.open();
       return;
     }
     custom_uploader = wp.media.frames.file_frame = wp.media({
       title: 'Choose Image',
       button: {
         text: 'Choose Image'
       },
       multiple: false
     });
     custom_uploader.on('select', function() {
       var attachment = custom_uploader.state().get('selection').first().toJSON();
       $('#category_image').val(attachment.url);
     });
     custom_uploader.open();
   });
 });