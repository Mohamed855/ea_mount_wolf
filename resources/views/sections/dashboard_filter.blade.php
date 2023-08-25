<form method="get" class="controle row">
    <div class="col-md-6 col-lg-5 col-xl-4 text-start">
        <input type="text" name="search" placeholder="search" value="{{ isset($_GET['search']) && $_GET['search'] !== '' ? $_GET['search'] : '' }}" class="form-control d-inline-block w-75">
        <button type="submit" class="d-inline-block btn btn-outline-success mb-1">search</button>
    </div>
    <div class="col-md-3">
        <div class="date">
            <input type="date" onchange="this.form.submit()" name="date" value="{{ isset($_GET['date']) && $_GET['date'] !== '' ? $_GET['date'] : 'mm/dd/yyyy' }}" class="form-control">
        </div>
    </div>
</form>
