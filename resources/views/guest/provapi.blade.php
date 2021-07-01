
<form action="{{ route('searchAparments') }}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="searchPlace">Cerca località</label>
        <input type="text" class="form-control" id="searchPlace" placeholder="inserisci lcoalità">
    </div>
   
    <button type="submit" class="btn btn-primary">Submit</button>
</form>