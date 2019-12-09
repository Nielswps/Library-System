@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-3">Add Item</h1>
        <form class="row" method="POST" action="{{ route('store-item') }}" enctype="multipart/form-data">
            @csrf
            <div class="col-12 d-flex justify-content-start mb-5">
                <label class="mt-1 mr-4" for="itemType"><h5>Item type:</h5></label>
                <select class="custom-select col-2 row" id="itemType" name="itemType">
                    <option selected disabled>Select item type...</option>
                    <option value="movie">Movie</option>
                    <option value="book">Book</option>
                </select>
            </div>
            <div class="container">

                <!--Adding a book-->
                <div class="itemType book mb-5">
                    <div class="col-12 mb-4">
                        <div class="form-group">
                            <label for="bookTitle">Title</label>
                            <input type="text" class="form-control" id="bookTitle" name="bookTitle" placeholder="Example: The Republic">
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
                <div class="itemType movie mb-5">
                    <div class="col-12 mb-4">
                        <div class="form-group">
                            <label for="movieTitle">Title</label>
                            <input type="text" class="form-control" id="movieTitle" name="movieTitle" placeholder="Example: The Godfather">
                        </div>

                        <div class="form-group">
                            <label for="releaseYear">Release Year</label>
                            <input type="text" class="form-control" id="releaseYear" name="releaseYear" placeholder="Example: 1972">
                        </div>
                        <div class="form-group">
                            <label for="diskType">Disk Type</label>
                            <select class="custom-select" id="diskType" name="diskType">
                                <option value="Blue-Ray">Blu-Ray</option>
                                <option value="DVD">DVD</option>
                            </select>
                        </div>
                    </div>
                </div>

                <hr class="itemType movie book horizontalDivider">

                <!--Adding any item with CSV-file-->
                <div class="itemType movie book col-12 mb-4 mt-5">
                    <div class="form-group row">
                        <label class="custom-file-label col-11" for="fileUpload">Upload CSV-file...</label>
                        <input class="custom-file-input col-11" type="file" name="fileUpload" id="fileUpload" accept="text/csv" placeholder="Upload CSV-file...">
                        <a class="m-auto" data-toggle="collapse" href="#fileFormattingInfo" role="button" aria-expanded="false" aria-controls="fileFormattingInfo">?</a>
                        <div class="collapse card card-body mt-2" aria-labelledby="fileFormattingInfo" id="fileFormattingInfo">
                            <p class="itemType book">
                                <!--The uploaded file has to be a .CSV-file in the format:<br>
                                Title, Release Year, Disk type <i><b>optional</b></i><br>
                                Example: The Godfather, 1972, DVD-->
                            </p>
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
