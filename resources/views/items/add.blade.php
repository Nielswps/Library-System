@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Item</h1>
        <form class="row" method="POST" action="{{ route('store-item') }}" enctype="multipart/form-data">
            @csrf
            <div class="col-12 d-flex justify-content-start mb-5">
                <label class="mt-1 mr-4" for="itemType"><h5>Item type:</h5></label>
                <select class="custom-select col-2 row" id="itemType" name="itemType">
                    <option selected disabled>Select item type...</option>
                    <option value="movie">Movie</option>
                    <option value="book">Book</option>
                </select>4
            </div>
            <div class="container">

                <!--Adding a book-->
                <div class="itemType book">
                    <div class="col-12 mb-5">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Example: The Republic">
                        </div>
                        <div class="form-group">
                            <label for="writer">Writer</label>
                            <input type="text" class="form-control" id="writer" name="writer" placeholder="Example: R. E. Allen">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" placeholder="(Optional)" rows="5"></textarea>
                        </div>
                    </div>
                </div>

                <!--Adding a movie-->
                <div class="itemType movie">
                    <div class="col-12 mb-4">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Example: The Godfather">
                        </div>
                        <div class="form-group">
                            <label for="release_year">Release Year</label>
                            <input type="text" class="form-control" id="release_year" name="release_year" placeholder="Example: 1972">
                        </div>
                    </div>
                </div>

                <!--Adding any item with CSV-file-->
                <div class="itemType movie book col-12 mb-4">
                    <div class="form-group row">
                        <label class="custom-file-label col-11" for="fileUpload">Upload CSV-file...</label>
                        <input class="custom-file-input col-11" type="file" name="fileUpload" id="fileUpload" accept="text/csv" placeholder="Upload CSV-file...">
                        <a class="m-auto" data-toggle="collapse" href="#fileFormattingInfo" role="button" aria-expanded="false" aria-controls="fileFormattingInfo">?</a>
                        <div class="collapse card card-body mt-2" aria-labelledby="fileFormattingInfo" id="fileFormattingInfo">

                            <!--Formatting for book-->
                            <p class="itemType book">
                                <!--The uploaded file has to be a .CSV-file in the format:<br>
                                Title, Release Year, Disk type <i><b>optional</b></i><br>
                                Example: The Godfather, 1972, DVD-->
                            </p>

                            <!--Formatting for movie-->
                            <p class="itemType movie">
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
            $("#itemType").change(function(){
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
