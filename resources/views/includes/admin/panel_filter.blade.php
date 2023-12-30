<form method="get" class="controls justify-content-between row">
    <div class="col-md-5 col-12 text-start">
        <input type="text" name="search" placeholder="Search" value="{{ isset($_GET['search']) && $_GET['search'] !== '' ? $_GET['search'] : '' }}" class="form-control py-2 d-inline-block" style="width: 74%">
        <button type="submit" class="d-inline-block btn btn-outline-success mb-1" style="width: 24%;max-width: 100px">Search</button>
    </div>
    <div class="col-md-3">
        <div class="date">
            <span class="d-inline px-2 w-25 float-start pt-1">From:</span><input type="date" onchange="this.form.submit()" name="from" value="{{ isset($_GET['from']) && DateTime::createFromFormat('Y-m-d', $_GET['from']) ? $_GET['from'] : 'mm/dd/yyyy' }}" class="form-control d-inline w-75">
        </div>
    </div>
    <div class="col-md-3">
        <div class="date">
            <span class="d-inline px-2 w-25 float-start pt-1">To:</span><input type="date" onchange="this.form.submit()" name="to" value="{{ isset($_GET['to']) && DateTime::createFromFormat('Y-m-d', $_GET['to']) ? $_GET['to'] : 'mm/dd/yyyy' }}" class="form-control d-inline w-75">
        </div>
    </div>
</form>
