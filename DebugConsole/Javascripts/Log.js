function Log()
{

}

Log.prototype.filterTable = function ()
{
    var key = $("#SearchTextBox").val().toLowerCase();

    $("#LogTable tbody tr").each(function () {
        if ($(this).children(".TagCell").html().toLowerCase().indexOf(key) >= 0
                || $(this).children(".TextCell").html().toLowerCase().indexOf(key) >= 0)
        {
            $(this).show();
        }
        else
        {
            $(this).hide();
        }
    });
};

$(function () {
    var log = new Log();

    $("#SearchTextBox").keyup(function () {
        log.filterTable();
    });
});