@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Item</h1>
        <form class="row" method="POST" action="{{ route('store-item') }}" enctype="multipart/form-data">
            @csrf
            <div class="col-12 d-flex justify-content-start mb-5">
                <label class="mt-1 mr-4" for="itemType"><h5>Item type:</h5></label>
                <select class="custom-select col-2 row" id="itemType" name="itemType">
                    <option selected disabled>Choose here</option>
                    <option value="movie" selected>Movie</option>
                    <option value="book">Book</option>
                </select>
            </div>
            <div class="container">
                <div class="itemType book">
                    <div class="col-12 mb-5">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label for="writer">Writer</label>
                            <input type="text" class="form-control" id="writer" name="writer" placeholder="Example: Chris Voss">
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="form-group row">
                        <label class="custom-file-label col-11" for="fileUpload">Upload CSV-file...</label>
                        <input class="custom-file-input col-11" type="file" name="fileUpload" id="fileUpload" accept="text/csv" placeholder="Upload CSV-file...">
                        <a class="m-auto" data-toggle="collapse" href="#fileFormattingInfo" role="button" aria-expanded="false" aria-controls="fileFormattingInfo">?</a>
                        <div class="collapse card card-body" aria-labelledby="fileFormattingInfo" id="fileFormattingInfo">
                            <p class="pr-0 mr-0">
                                The uploaded file has to be a .CSV-file in the format:<br>
                                Title, Release Year, Disk type <i><b>optional</b></i><br>
                                Example: The Godfather, 1972, DVD
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <input type="submit" class="btn btn-primary m-2 btn-block" value="Add">
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
        $(document).ready(function(){
            $("select").change(function(){
                $(this).find("option:selected").each(function(){
                    var optionValue = $(this).attr("value");
                    if(optionValue){
                        $(".itemType").not("." + optionValue).hide();
                        $("." + optionValue).show();
                    } else{
                        $(".itemType").hide();
                    }
                });
            }).change();
        });
    </script>
@endsection
