$(document).ready(function() {
    var currentYear = (new Date()).getFullYear();
    var pastYears = currentYear - 10;
    var futureYears = currentYear + 10;

    $('#datepicker').datepicker({
        format: 'yyyy',
        startView: 'years',
        minViewMode: 'years',
        autoclose: true,
        endDate: '+' + futureYears + 'y',
        startDate: '-' + pastYears + 'y',
    });
});
