var MString=function(string)
{
    this.string=string;
};

MString.prototype.endsWith = function(suffix) {
    return this.string.indexOf(suffix, this.length - suffix.length) !== -1;
};