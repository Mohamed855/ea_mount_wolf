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
    function generateOneSectorLines(id){
        let sector = document.getElementById('s_' + id);
        let sectorLines = document.getElementById('sl_' + id);
        let activeSectorLines = document.getElementsByClassName('activeSectorLines')[0];
        if (activeSectorLines) {
            activeSectorLines.style.display = 'none';
            activeSectorLines.className = '';
        }
        if (sector.checked){
            sectorLines.style.display = 'flex';
            sectorLines.className = 'activeSectorLines';
        }
    }
</script>
