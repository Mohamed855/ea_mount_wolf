<form method="get" class="controle row pb-5">
    <div class="col-md-3">
        <select name="filter" onchange="this.form.submit()" class="form-control py-2">
            <option value="none" {{ !isset($_GET['filter']) ? 'selected' : '' }} disabled selected>Group by</option>
            <option value="date" {{ isset($_GET['filter']) && $_GET['filter'] === 'date' ? 'selected' : '' }}>Date</option>
            <option value="name" {{ isset($_GET['filter']) && $_GET['filter'] === 'name' ? 'selected' : '' }}>Name</option>
            <option value="size" {{ isset($_GET['filter']) && $_GET['filter'] === 'size' ? 'selected' : '' }}>Size</option>
        </select>
    </div>
    <div class="col-md-3">
        <div class="date">
                <input type="date" onchange="this.form.submit()" name="date" value="{{ isset($_GET['date']) && DateTime::createFromFormat('Y-m-d', $_GET['date']) ? $_GET['date'] : 'mm/dd/yyyy' }}" class="form-control py-2">
        </div>
    </div>
</form>
