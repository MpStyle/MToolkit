var MQueryString = function ()
{
    this.map = {};

    var outerThis = this;

    location.search.replace(
            new RegExp("([^?=&]+)(=([^&]*))?", "g"),
            function ($0, $1, $2, $3) {
                outerThis.map[$1] = $3;
            }
    );
};

/**
 * Restituisce il valore di <i>name</i>, altrimenti null.
 * 
 * @param string name
 * @returns null|string
 */
MQueryString.prototype.getValue = function (name)
{
    var toReturn = this.map[name];

    if (typeof toReturn === "undefined")
    {
        return null;
    }

    return toReturn;
};