<!DOCTYPE html>
<html lang="en">
<head>
    <title>Page title</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
    {{-- <link href="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"> --}}
    <link rel="stylesheet" href="css/bulma/bulma.min.css">
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="icon" type="image/png" sizes="32x32" href="shuffle-for-bulma.png">
    <script src="js/main.js"></script>

</head>
<body>
    <div class="">
<section>
  <nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container-fluid">
      <button class="navbar-burger navbar-toggler" type="button">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse">
        <div class="ms-auto d-flex align-items-center">
          <div class="d-inline-flex align-items-center">
            <span class="d-inline-flex me-4 align-items-center justify-content-center rounded-2 bg-secondary" style="width: 40px; height: 40px;">
                <img class="img-fluid" src="sirius-assets/images/brands/twitch.svg" alt="">
            </span>
            {{-- <img class="img-fluid rounded-2 me-4" style="width: 40px; height: 40px;" src="https://images.unsplash.com/photo-1593789382576-54f489574d26?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=faces&amp;cs=tinysrgb&amp;fit=crop&amp;h=128&amp;w=128" alt=""> --}}
            <div class="pe-4">
              <p class="fw-bold text-dark mb-0"> {{ auth()->user()->name }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
</section>

@if (count($errors) > 0)
<div class="row">
    @foreach ($errors->all() as $error)
        <div class="py-8 px-6 w-25">
        <div class="border-start border-4 border-warning">
            <div class="p-6 border border-2 border-warning rounded-end">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                <span class="d-inline-block me-2 text-warning">
                    <svg width="20" height="20" viewbox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 0C4.5 0 0 4.5 0 10C0 15.5 4.5 20 10 20C15.5 20 20 15.5 20 10C20 4.5 15.5 0 10 0ZM10 15C9.4 15 9 14.6 9 14C9 13.4 9.4 13 10 13C10.6 13 11 13.4 11 14C11 14.6 10.6 15 10 15ZM11 10C11 10.6 10.6 11 10 11C9.4 11 9 10.6 9 10V6C9 5.4 9.4 5 10 5C10.6 5 11 5.4 11 6V10Z" fill="currentColor"></path>
                    </svg>
                </span>
                <h3 class="h6 mb-0 fw-bold text-warning-dark">{{ $error }}</h3>
                </div>
            </div>
            </div>
        </div>
        </div>
    @endforeach
    </div>
@endif

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card w-50 m-auto">
                    <div class="card-header bg-info text-white">
                        <h4>Envie um corte</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group" id="file-input">
                            <input type="file" id="pickfiles" class="form-control">
                            <div id="filelist"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<section class="py-6">
  <div class="container">
    <div class="row">
    <div class="py-4 d-flex justify-content-center">
            {!! $cortes->links() !!}
        </div>
        @foreach ($cortes as $corte)
            <div class="col-12 col-md-6 col-lg-12 mb-6">
                <div class="card p-6">
                    <div class="card-body p-0">
                        <div class="d-flex mb-6 align-items-center">
                            <p class="mb-0 text-dark fw-bold">{{ $corte->path }}</p>
                        </div>
                        <div class="mb-6">
                            <div class="d-flex mb-4 align-items-center">
                                <video  controls>
                                    <source src="/storage/upload/testChunk/{{$corte->path}}" type="video/mp4">
                                        Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                        <div class="text-center position-relative bg bg-light rounded" style="height: 4px;">
                            Upado por {{$corte->user->name}}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class=" py-4 d-flex justify-content-center">
            {!! $cortes->links() !!}
        </div>
    </div>
  </div>
</section>


    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('/plupload/js/plupload.full.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var path = "{{ asset('/plupload/js/') }}";
            var uploader = new plupload.Uploader({
            browse_button: 'pickfiles',
            container: document.getElementById('file-input'),
            url: '{{ route("corte.upload") }}',
            chunk_size: '1mb', // 1 MB
            max_retries: 0,
            filters: {
                max_file_size: '200mb'
            },
            multipart_params : {
                // Extra Parameter
                "_token" : "{{ csrf_token() }}"
            },
            init: {
                PostInit: function () {
                    document.getElementById('filelist').innerHTML = '';
                },
                FilesAdded: function (up, files) {
                    plupload.each(files, function (file) {
                        console.log('FilesAdded');
                        console.log(file);
                        document.getElementById('filelist').innerHTML += '<p id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></p>';
                    });
                    uploader.start();
                },
                UploadProgress: function (up, file) {
                    console.log(file.id);
                    console.log("procuro esse id /|");
                    document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
                },

                FileUploaded: function(up, file, result){
                    console.log('FileUploaded');
                    console.log(file);
                    console.log(JSON.parse(result.response));
                    responseResult = JSON.parse(result.response);

                    if (responseResult.ok==0) {
                        toastr.error(responseResult.info, 'Error Alert', {timeOut: 5000});
                    }

                    if (result.status != 200) {
                        document.getElementById(file.id).classList.add('text-danger')
                        //toastr.error('Your File Uploaded Not Successfully!!', 'Error Alert', {timeOut: 5000});
                    }

                    if (responseResult.ok==1 && result.status == 200) {
                        //toastr.success('Your File Uploaded Successfully!!', 'Success Alert', {timeOut: 5000});
                        document.getElementById(file.id).classList.add('text-success')

                    }

                },
                UploadComplete: function(up, file){
                    console.log(file);
                    window.location.reload();
                    // toastr.success('Your File Uploaded Successfully!!', 'Success Alert', {timeOut: 5000});
                },
                Error: function (up, err, file) {
                    // DO YOUR ERROR HANDLING!
                    //toastr.error('Your File Uploaded Not Successfully!!', 'Error Alert', {timeOut: 5000});
                    console.log(err);
                }
                }
            });
            uploader.init();
        });
    </script>
</body>
