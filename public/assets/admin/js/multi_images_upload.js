$(document).ready(function(){
    $(document).on('change', '#multi_image', function(e){
        e.preventDefault();
        var pre_id = $(this).attr('data-id');
        var variation_id = $('.variation_'+pre_id+'').val();
        var files = e.target.files,
        filesLength = files.length;

        if(variation_id > 0){
            if(filesLength > 5){
                alert('Choose images between 1 to 5 only.');
            }else{
                if($("input[id='images_"+variation_id+"']").length > 5){
                    $(this).prop('disabled', 'disabled');
                }else{
                    if($('.variation_'+pre_id+'').attr('data-id') == pre_id){
                        if($('.variation_'+pre_id+'').val() == 'Select Variant'){
                            alert('Select variant first !!');
                        }else{
                            $('.variation_'+pre_id+'').prop('disabled', 'disabled');
                            $('.preview_images_'+pre_id).append('<input type="hidden" name="variation[]" value="'+$('.variation_'+pre_id+'').val()+'">');
                            for(var i = 0; i < filesLength; i++){
                                var f = files[i];
                                var image_names = f.name;
                                var fileReader = new FileReader();
                                fileReader.Name = f.name;

                                fileReader.onload = (function(e){
                                    var f_name = e.target.Name;
                                    var image_path = e.target.result;
                                    var name = f_name.split('.')[0];

                                    $('.preview_images_'+pre_id).append(""
                                        +"<li class='ui-state-default sortable_dragable_image_li remove_image_"+name+"' style='float:left; list-style-type: none;'>"
                                            +"<input type='hidden' id='images_"+variation_id+"' name='images["+variation_id+"][]' value="+f_name+">"
                                            +"<input type='hidden' id='url_"+variation_id+"' name='url["+variation_id+"][]' value="+image_path+">"
                                            +"<span class='pip'>"
                                                +"<img src='"+image_path+"' alt='Product Images' style='width:135px; height:110px;'/>"
                                                +"<span class='remove' id="+pre_id+" data-id='remove_image_"+name+"'>Remove</span>"
                                            +"</span>"
                                        +"</li>"
                                    ).sortable('refresh');
                                });

                                $('.preview_images_'+pre_id).sortable();
                                fileReader.readAsDataURL(f);
                            }
                        }
                    }
                }
            }
        }else if(variation_id == undefined){
            for(var i = 0; i < filesLength; i++){
                var f = files[i];
                var image_names = f.name;
                var image_names = f.name;
                var fileReader = new FileReader();
                fileReader.Name = f.name;

                fileReader.onload = (function(e){
                    var f_name = e.target.Name;
                    var image_path = e.target.result;
                    var name = f_name.split('.')[0];

                    $('.preview_images').append(""
                        +"<li class='ui-state-default sortable_dragable_image_li remove_image_"+name+"' style='float:left; list-style-type: none;'>"
                            +"<input type='hidden' name='url[]' value="+image_path+">"
                            +"<span class='pip'>"
                                +"<img src='"+image_path+"' alt='Product Images' style='width:135px; height:110px;'/>"
                                +"<input type='text' class='form-control' name='banner_url[]'>"
                                +"<span class='remove' id="+name+" data-id='remove_image_"+name+"'>Remove</span>"
                            +"</span>"
                        +"</li>"
                    ).sortable('refresh');
                });

                $('.preview_images').sortable();
                fileReader.readAsDataURL(f);
            }
        }
    });

    //Remove Image
    $(document).on('click', '.remove', function(){
        $('.'+$(this).attr('data-id')+'').remove();
        if($('#multi_image').attr('data-id') == $(this).attr('id')){
            if($('#'+$(this).attr('id')+'').length > 5){
                $("input[data-id='"+$(this).attr('id')+"']").prop('disabled', true);
            }else{
                $("input[data-id='"+$(this).attr('id')+"']").prop('disabled', false);
            }
        }
    });
});