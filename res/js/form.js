/**
*使用方法：
* var form = new tsForm('form');
* form.validate('username','isEmpty','用户名不能为空！');
* form.validate('username',form.reg.username,'用户名格式不正确');
* form.validate('username',/^[\w]{6,15}$/,'用户名格式不正确');
* form.reg = {
      'username':/^[\w]{6,15},$/
  };自定义正则库
  
  自定义验证失败显示方法
  form.showError = function(name,msg){
    form.editForm.[name]focus();
    alert(msg);
  }
  获取表单数据
  form.getData();
  表单序列化
  form.serialize();
  获取某一个表单控件值
  form.get("name");
  
* 
*/
function tsForm(formName){
    
     var self = this;
     
     var editForm = document[formName];
     
     /*正则表达式库，可以根据需要重写，用于self.validate,self.check 的reg参数*/
     self.reg = {
        'tel' : /^[0-9]{11}$/,
        'email':/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/,
        'username': /^[\w]{6,15}$/
     }
     
     /*form表单不存在*/
     if( editForm == undefined ){
        throw ('tsForm error:' + formName + 'form name is not exist!');
     }
     
     /*判断，真返回true，假返回false,并调用self.showError*/
     self.validate = function(name,reg,msg){
        if( self.check(name,reg,msg) ){
            return true;
        }else{
            self.showError(name,msg);
            return false;
        }
     }
     
     /*判断并且返回true|false*/
     self.check = function(name,reg,msg){
        
        /*form 表单控件不存在*/
        if( typeof editForm[name] != "object" ){
            throw ('tsForm error:' + name + ' of form control is not exist!' );
        }
        
        /*判断是否为空*/
        if( reg == 'isEmpty' ){
            if( self.trim( editForm[name].value ) ){
                return true;
            }else{
                return false;
            }
        /*根据正则来判断*/
        }else if(typeof reg.test == "function"){
            if( reg.test( editForm[name].value) ){
                return true;
            }else{
                return false;
            }
        /*判断是否相等*/
        }else{
            if( editForm[name].value == reg ){
                return true;
            }else{
                return false;
            }
        }
        
     }
     
     /*显示错误，self.showError是可以根据自己的需要重写*/   
     self.showError = function(name,msg){
        editForm[name].focus();
        alert(msg);
     }
     
     /*去除空格*/
     self.trim = function(str){
        return str.replace(/(^\s*)|(\s*$)/g,'');
     }
     
     /*获取某一个表单控件的值*/
     self.get = function(name){
        if( typeof editForm[name] != undefined ){
            return editForm[name].value;
        }else{
            return false;
        }
     }
     
     /*获取表单数据*/
     self.getData = function(){
        var formData = {};
        for( var i=0;i<editForm.length;i++ ){
            if( editForm[i].type != "button" || editForm[i].type != "submit" ){
                if( editForm[i].name != "" ){
                    if( editForm[i].name.match(/\[\]$/) && editForm[i].name.length >2 ){
                        var namekey = editForm[i].name.substr( 0, editForm[i].name.length-2 )
                        if( typeof formData[namekey] == "undefined" ){
                            formData[namekey] = [];
                        }
                        formData[ namekey ].push( editForm[i].value );
                    }else{
                        formData[editForm[i].name] = editForm[i].value;
                    }
                    
                }
            }
        }
        return formData;
     }
     
     /*表单序列化*/
     self.serialize = function(){
        var formData = [];
        for( var i=0;i<editForm.length;i++ ){
            if( editForm[i].type != "button" || editForm[i].type != "submit" ){
                if( editForm[i].name != "" ){
                    formData.push( editForm[i].name + '=' + editForm[i].value );
                }
            }
        }
        return formData.join('&');
     }
     
}