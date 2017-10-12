<button type="button"
        class="btn btn-xs btn-primary"
        data-toggle="modal"
        data-target="#addMedia">Add Image</button>
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
                  action="{{ url('/media') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <p>
                        <strong>To avoid duplication</strong>, we offer a media library feature. Upload and categorize your images here and they will be available across your campaigns.
                    </p>
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
                                name="category"
                                required>
                            <option value="">Choose Site Category</option>
                            @foreach(App\Category::all() as $category)
                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endforeach
                        </select>
                        <label class="error hide"
                               for="category"></label>
                    </div>

                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control m-b"
                                value=""
                                name="location_type"
                                required>
                            <option value="">Choose zone type</option>
                            @foreach(App\LocationType::all() as $locationType)
                            <option value="{{ $locationType->id }}">{{ $locationType->width . 'x' . $locationType->height . ' ' . $locationType->description }}</option>
                            @endforeach
                        </select>

                        <label class="error hide"
                               for="location_type"></label>
                    </div>
                    <div class="form-group">
                        <label class="btn btn-success btn-block"
                               for="image_file">
                            <i class="fa fa-upload"></i>&nbsp;&nbsp;
                            <span class="bold">Upload</span>
                        </label>
                        <input type="file"
                               name="file"
                               id="image_file"
                               accept="image/*"
                               required
                               class="hide"
                               hidden/>
                        <label class="error mt-10"
                               style="display: none;"
                               for="file">
                            <i class="text-danger fa fa-exclamation-triangle"></i>&nbsp;&nbsp;
                            <span class="text-danger"></span>
                        </label>
                        <label class="success mt-10"
                               style="display: none;"
                               for="file">
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
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-white"
                            data-dismiss="modal">Cancel</button>
                    <button type="submit"
                            name="submit"
                            class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
