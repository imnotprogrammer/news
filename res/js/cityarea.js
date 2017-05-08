function cityarea(){
    
    var self = this;
    //var html = ['<option value="0">请选择省</option>'];
    var html = [];
    
    self.defaultProv = 3;
    self.defaultCity = 39;
    self.defaultArea = 0;
    
    for( var i=0;i<areas.length;i++ ){
        
        html.push('<option value="'+areas[i].no+'" >' + areas[i].name + '</option>' );
        $('select[name=prov]').html( html.join('\n') );
    }
    
    self.change = function(provId,cityId,AreaId){
        self.defaultProv = provId;
        self.defaultCity = cityId;
        self.defaultArea = AreaId;
        self.changeProv();
    }
    
    self.changeProv = function(){
        $('select[name=prov]').find('option').attr('selected',false).each(function(){
            if( $(this).val() == self.defaultProv ){
                $(this).attr('selected',true);
            }
        });
        self.changeCity();
    }
    
    
    self.changeCity = function(){
        var provNo = $('select[name=prov]').val();
        
        //var cityHtml = ['<option value="0" pno="0">请选择市</option>'];
        var cityHtml = [];
        
        if( provNo == "0" ){
           // $('select[name=city]').html('<option value="0" pno="0">请选择市</option>');
           // $('select[name=area]').html('<option value="0" pno="0">请选择区</option>');
        }else{
            
            for( var i=0;i<areas.length;i++ ){
                if(areas[i].no == provNo){
                    for( var j=0;j<areas[i]['citys'].length;j++ ){
                        var city = areas[i]['citys'][j];
                        cityHtml.push('<option value="' +city.no+ '" pno="' + city.pno + '" >'+city.name+'</option>');
                    }
                }
            }
            $('select[name=city]').html(cityHtml.join('\n'));
            $('select[name=city]').find('option').each(function(){
                 if( $(this).val() == self.defaultCity ){
                    $(this).attr('selected',true);
                 }
            });
            self.changeArea();
        }
    }
    
     self.changeArea = function(){
        
        var provNo = $('select[name=prov]').val();
        
        var cityNo = $('select[name=city]').val();
        
        var areaHtml = [];
    
        if( cityNo == "0" ){
            //$('select[name=area]').html('<option value="0" pno="0">请选择区</option>');
        }else{
            for( var i=0;i<areas.length;i++ ){
                if(areas[i].no == provNo){
                    for( var j=0;j<areas[i]['citys'].length;j++ ){
                        var city = areas[i]['citys'][j];
                        if( city.no == cityNo ){
                            for( var k=0;k<city['areas'].length;k++){
                                var area = city['areas'][k];
                                areaHtml.push('<option value="' +area.no+ '" pno="' + area.pno + '" >'+area.name+'</option>');
                            }
                        }
                    }
                }
            }
            $('select[name=area]').html(areaHtml.join('\n'));
            $('select[name=area]').find('option').each(function(){
                 if( $(this).val() == self.defaultArea ){
                    $(this).attr('selected',true);
                 }
            });
        }
        
    }
    
}