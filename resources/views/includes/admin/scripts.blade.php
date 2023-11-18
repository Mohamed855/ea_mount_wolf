<script type="text/javascript">
    function generateSectorLines(id){
        let sector = document.getElementById('s_' + id);
        let sectorLines = document.getElementById('sl_' + id);

        if (sector.checked){
            sectorLines.style.display = 'flex';
        } else {
            sectorLines.style.display = 'none';
        }
    }
</script>
