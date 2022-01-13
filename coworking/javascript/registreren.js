function Start()
{
    var select = document.getElementById("jaar");
    for (var i = 2022; i >= 1910; i--)
    {
        var opt = document.createElement('option');
        opt.value = i;
        opt.innerHTML = i;
        select.appendChild(opt);
    }
    var select3 = document.getElementById("maand");
    for (var i = 1; i <= 12; i++)
    {
        var opt = document.createElement('option');
        opt.value = i;
        opt.innerHTML = i;
        select3.appendChild(opt);
    }


    var select2 = document.getElementById("dag");
    for (var i = 1; i <= 31; i++)
    {
        var opt = document.createElement('option');
        opt.value = i;
        opt.innerHTML = i;
        select2.appendChild(opt);
    }
}