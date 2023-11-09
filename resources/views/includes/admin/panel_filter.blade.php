<form method="get" class="controls justify-content-between row">
    <div class="col-md-6 col-12 text-start">
        <input type="text" name="search" placeholder="Search" value="{{ isset($_GET['search']) && $_GET['search'] !== '' ? $_GET['search'] : '' }}" class="form-control d-inline-block" style="width: 74%">
        <button type="submit" class="d-inline-block btn btn-outline-success mb-1" style="width: 24%;max-width: 100px">Search</button>
    </div>
    <div class="col-md-4 col-12 text-start">
        <div class="date">
            <input type="date" onchange="this.form.submit()" name="date" value="{{ isset($_GET['date']) && $_GET['date'] !== '' ? $_GET['date'] : 'mm/dd/yyyy' }}" class="form-control">
        </div>
    </div>
</form>