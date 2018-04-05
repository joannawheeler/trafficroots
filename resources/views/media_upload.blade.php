<button type="button"
        class="btn btn-xs btn-primary"
        data-toggle="modal"
        data-target="#addMedia"><i class="fa fa-plus-square-o"></i>&nbsp;&nbsp;Add Image</button>
<div class="modal inmodal"
     id="addMedia"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button"
                        class="close"
                        data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">New Image</h4>
            </div>
            <form name="media_form"
                  id="media_form"
                  class="form-horizontal"
                  enctype="multipart/form-data"
                  role="form"
		  method="POST"
                  @if( $_SERVER['REQUEST_URI'] == '/campaign')
                  onsubmit="return submitMediaForm();"
                  @endif
                  action="{{ url('/media') }}">
                {{ csrf_field() }}
                <div class="modal-body">                    
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text"
                               placeholder="Enter your image name"
                               value="{{ old('media_name') }}"
                               class="form-control"
                               name="media_name"
                               required>

                        <label class="error hide"
                               for="media_name"></label>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control m-b"
                                name="image_category"
                                required>
                            <option value="">Choose Image Category</option>
                            @foreach(App\Category::all() as $category)
                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endforeach
                        </select>
                        <label class="error hide"
                               for="image_category"></label>
                    </div>

                    <div class="form-group">
                        <label>Location Type</label>
                        <select class="form-control m-b"
                                value=""
                                name="image_size"
                                required>
                            <option value="">Choose Image Size</option>
                            @foreach(App\LocationType::all() as $locationType)
                            <option value="{{ $locationType->id }}">{{ $locationType->width . 'x' . $locationType->height . ' ' . $locationType->description }}</option>
                            @endforeach
                        </select>

                        <label class="error hide"
                               for="image_size"></label>
                    </div>
                    <div class="form-group">
                        <label class="btn btn-success btn-block"
                               for="image_file">
                            <i class="fa fa-upload"></i>&nbsp;&nbsp;
                            <span class="bold">Upload</span>
                        </label>
						<br>
						<div class="text-center image-preview" style="border: 0px;">
							<img id="previewImgFile" src="#" alt="Preview Image" />
						</div>
                        <input type="file"
                               name="file"
                               id="image_file"
                               accept="image/*"
                               required
                               class="hide"
                               hidden/>
                        <label class="error mt-10"
                               style="display: none;"
                               for="image_file">
                            <i class="text-danger fa fa-exclamation-triangle"></i>&nbsp;&nbsp;
                            <span class="text-danger"></span>
                        </label>
                        <label class="success mt-10"
                               style="display: none;"
                               for="image_file">
                            <p>
                                <i class="text-success fa fa-check"></i>&nbsp;&nbsp;
                                <span class="text-primary"></span>
                            </p>
                            <div class="ibox-content w-160">
                                <img src=""
                                     alt="preview"
                                     width="120"
                                     height="120">
                            </div>
                        </label>
                    </div>
                    <div>      
                        <div class="well">
                            <ul>
                                <li>Media uploaded must be image files.</li>
                                <li>To avoid duplication, we offer a Media Library feature.</li>
                                <li>Upload and Categorize your images here and they will be available across all your campaigns.</li>
                                <li>On this page you are creating a new Media item by naming it and selecting a Location Type and Category.</li>
                             </ul>
                        </div>
                    </div>
                </div>                
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-white"
                            data-dismiss="modal">Cancel</button>
                    <button type="submit"
                            name="submit"
                            id="btnSubmit"
                            class="btn btn-primary">Submit</button>
		</div>
                        <input type="hidden"
                               name="return_url"
                               id="return_url"
                        @if( $_SERVER['REQUEST_URI'] == '/campaign')
                               value="campaign">
                        @else
                               value="library">
                        @endif
            </form>
        </div>
    </div>
</div>
@if($_SERVER['REQUEST_URI'] == '/campaign')
<script type="text/javascript">
	
function submitMediaForm(){
        // Get form
        var form = $('#media_form')[0];

		// Create an FormData object
        var data = new FormData(form);

		// If you want to add an extra field for the FormData
        //data.append("CustomField", "This is some extra data, testing");

		// disabled the submit button
        $("#btnSubmit").prop("disabled", true);

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "/media",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
                console.log("SUCCESS : ", data);
                $("#btnSubmit").prop("disabled", false);
                $("#addMedia").modal('hide');
                toastr.success('Upload Complete!');
                reloadMedia();
            },
            error: function (e) {

                toastr.error(e.responseText);
                console.log("ERROR : ", e);
                $("#btnSubmit").prop("disabled", false);

            }
        });	
		    return false;
}
</script>
@endif
