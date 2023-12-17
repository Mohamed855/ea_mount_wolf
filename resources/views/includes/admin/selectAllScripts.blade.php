<script>
    function selectAllTitles() {
        let select_all = document.getElementById("select_all_titles");
        let title_checkboxes = document.getElementsByClassName("title_checkbox");
        for (let i = 0; i < title_checkboxes.length; i++) {
            title_checkboxes[i].checked = select_all.checked;
        }
    }
    function selectAllSectors() {
        let select_all_sectors = document.getElementById("select_all_sectors");
        let sector_checkboxes = document.getElementsByClassName("sector_checkbox");
        for (let i = 0; i < sector_checkboxes.length; i++) {
            sector_checkboxes[i].checked = select_all_sectors.checked;
            generateSectorLines(sector_checkboxes[i].value);
        }
    }
    function selectAllLines() {
        let select_all_lines = document.getElementById("select_all_lines");
        let line_checkboxes = document.getElementsByClassName("line_checkbox");
        for (let i = 0; i < line_checkboxes.length; i++) {
            line_checkboxes[i].checked = select_all_lines.checked;
        }
    }
    document.getElementById("select_all_titles").addEventListener("click", selectAllTitles);
    document.getElementById("select_all_sectors").addEventListener("click", selectAllSectors);
    document.getElementById("select_all_lines").addEventListener("click", selectAllLines);
</script>
