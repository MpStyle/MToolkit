var MString = function(string)
{
    this.string = string;
};

MString.prototype.endsWith = function(prefix) {
    return this.string.indexOf(prefix) == 0;
};

MString.prototype.endsWith = function(suffix) {
    return this.string.indexOf(suffix, this.length - suffix.length) !== -1;
};