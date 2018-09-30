jQuery( document ).ready(function($) {
    // Add description to Taxonomy metaboxes
    var taxonomydiv = $('.categorydiv')
    var notice;
    if ($(taxonomydiv).length){
        $(taxonomydiv).each(function(){
            if($(this).attr('id') === 'taxonomy-site'){
                notice = '** By selecting a site, you determine what website, landing page, or microsite the post is available for.';
            } else if ($(this).attr('id') === 'taxonomy-content_type'){
                notice = '** Select the type of content for this post, this will help content organziation and order of display on the site.';
            } else if ($(this).attr('id') === 'taxonomy-content_fields') {
                notice = '** Select from the available fields to add custom content fields to this post.';
            } else {
                notice = null;
            }
            // Append notice to metabox
            $(this).append(notice);
        });
    }

    // Add description to Featured Image metabox
    thumbnailBox = $('#postimagediv .inside');
    if ($(thumbnailBox).length){
        $(thumbnailBox).append('** Make sure your image is at minimum <b>720 x 415 px</b> (either vertical or horizontal) in size. If the image is larger, it will be automactilaly cropped.');
    }

});
