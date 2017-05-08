string.prototype.trim = function(){
    return this.replace(/(^\s*)|(\s*$)/g,'');
}
Array.prototype.in_array = function(){
    for(i=0;i<this.length && this[i]!=e;i++); 
    return !(i==this.length); 
}
Array.prototype.indexOf = function(){
    for(i=0;i<this.length && this[i]!=e;i++); 
    return !(i==this.length);
}