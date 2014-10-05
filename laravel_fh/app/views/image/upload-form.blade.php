
@section('title', 'image')

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/jquery.Jcrop.min.css') }}">
@stop

@section('scripts')
<script type="text/javascript">
  var FileAPI = {
          debug: false
          , staticPath: "{{ url('js/vendor/uploader') }}/"
          , postNameConcat: function (name, idx){
        return  name + (idx != null ? '['+ idx +']' : '');
      }
  };
</script>
<script src="{{ asset('js/vendor/uploader/FileAPI.min.js') }}"></script>
<script src="{{ asset('js/vendor/uploader/FileAPI.exif.js') }}"></script>
<script src="{{ asset('js/vendor/uploader/jquery.fileapi.js') }}"></script>
<script src="{{ asset('js/vendor/uploader/jquery.Jcrop.min.js') }}"></script>

<script type="text/javascript">
jQuery(function ($){
  $('#upload-avatar').fileapi({
     url: '{{ route("image.upload") }}',
     accept: 'image/*',
     data: { _token: "{{ csrf_token() }}" },
     imageSize: { minWidth: 200, minHeight: 200 },
     elements: {
        active: { show: '.js-upload', hide: '.js-browse' },
        preview: {
           el: '.js-preview',
           width: 100,
           height: 100
        },
        progress: '.js-progress'
     },
     autoUpload: true,

     onSelect: function (evt, ui){
        var file = ui.all[0];
        if( file ){
          $('#cropper-preview').show();

          $('.js-img').cropper({
             file: file,
             bgColor: '#fff',
             maxSize: [$('#cropper-preview').width(), $(window).height()],
             minSize: [100, 100],
             selection: '90%',
             aspectRatio: 1,
             onSelect: function (coords){
                $('#upload-avatar').fileapi('crop', file, coords);
             }
          });
        }
     },

    onComplete: function(evt, xhr)
     {

       alert('complete');
      
      try {
        var result = FileAPI.parseJSON(xhr.xhr.responseText);
        alert(result.images.filename);
        $('#avatar-hidden').attr("value",result.images.filename);
      } catch (er){
        FileAPI.log('PARSE ERROR:', er.message);
      }
     }
  });
});


</script>
@stop

@section('content')

  <div class="form-group">
 
              <div class="col-lg-8">
                <input type="hidden" id="avatar-hidden" name="avatar" value="">
                <div id="upload-avatar" class="upload-avatar">
                  <div class="userpic" >
                     <div class="js-preview userpic__preview"></div>
                  </div>
                  <div class="btn btn-sm btn-primary js-fileapi-wrapper">
                     <div class="js-browse">
                        <span class="btn-txt">{{ trans('user.choose') }}</span>
                        <input type="file" name="filedata">
                     </div>
                     <div class="js-upload" style="display: none;">
                        <div class="progress progress-success"><div class="js-progress bar"></div></div>
                        <span class="btn-txt">{{ trans('user.uploading') }}</span>
                     </div>
                  </div>
                </div>
              </div>
            </div>
          

@stop

