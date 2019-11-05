

var update = {

    linkData:function( url, id ){
        var str = this.getFromData( id );
        if( str == false ) { 
            alert( str );
            alert( '信息输入不完整' );
            return false;
        };
        // var url = "{:U('UpdateData/testLink')}";
        this.submitAjax( str, url );
    },


    linkDataAll:function( url ){
        var str = this.getFromAllData();
        if( str == false ) { 
            alert( '信息输入不完整' );
            return false;
        };
        // var url = "{:U('UpdateData/testLinkAll')}";
        this.submitAjax( str, url );
    },


    getFromData:function( id ) {

        var str = '';
        var frmObj = $("#"+id);
        var input_Obj = frmObj.find("input:text");
        var result = true;

        //由上面的表单获取里面的值
        var input_length = input_Obj.length;

        input_Obj.each(function(i){

            var thisName = $(this).attr('name');
            var thisVal = $(this).val();

            if ( thisVal == '' ) {
                // alert( id +'下的'+ thisName +'不能为空' );
                $(this).siblings('i').css("color","red");
                result = false;
            } else {
                $(this).siblings('i').css("color","gray");
            }

            str += '"'+(thisName+'":"'+thisVal)+'"';
            if ( i+1 < input_length ) {
                str += ',';
            }
            // alert( result ); // 未完待续
        });

        if ( result == false ) { return false; } 

        return '{'+str+'}';

    },

    getFromAllData:function() {

        var str = '';
        var value = '';
        var fomObj = $('from');
        // var value = new Array();
        var input_length = fomObj.length;
        var result = true;

        fomObj.each(function(i){

            value = window.update.getFromData( $(this).attr('id') );

            if ( value === false ) {
                result = false;
            }

            str += value;

            if ( i+1 < input_length ) {
                str += ',';
            }

        });

        if ( result == false ) { return false };
        // return JSON.stringify('['+str+']');
        return '['+str+']';
    },

    submitAjax:function( str, url ) { 
        $.ajax({
            type: "POST",
            dataType: "json",
            url: url,
            data: str,
            // traditional: true,
            success: function (data) {

                alert(JSON.stringify(data))
                alert( data.sqlserver );
                // if ( data = true )
                // console.log(result);    //打印服务端返回的数据(调试用)
                // if (result.resultCode == 200) {
                //     alert("SUCCESS");
                // }; 
                // alert(data.username);
            },
            error : function() {
                alert("提交异常！");
            }
        });
    }

}



        // function linkData( id ){
        //     var str = getFromData( id );
        //     if( str == false ) { 
        //         alert( str );
        //         alert( '信息输入不完整' );
        //         return false;
        //     };
        //     var url = "{:U('UpdateData/testLink')}";
        //     submitAjax( str, url );
        // }


        // function linkDataAll(){
        //     var str = getFromAllData();
        //     alert( str );
        //     if( str == false ) { 
        //         alert( '信息输入不完整' );
        //         return false;
        //     };
        //     var url = "{:U('UpdateData/testLinkAll')}";
        //     submitAjax( str, url );
        // }


        // function getFromData( id ) {

        //     var str = '';
        //     var frmObj = $("#"+id);
        //     var input_Obj = frmObj.find("input:text");
            
        //     //由上面的表单获取里面的值
        //     var input_length = input_Obj.length;

        //     input_Obj.each(function(i){

        //         var thisName = $(this).attr('name');
        //         var thisVal = $(this).val();

        //         if ( thisVal == '' ) {
        //             // alert( id +'下的'+ thisName +'不能为空' );
        //             $(this).siblings('i').css("color","red");
        //             result = false;
        //         } else {
        //             $(this).siblings('i').css("color","gray");
        //         }

        //         str += '"'+(thisName+'":"'+thisVal)+'"';
        //         if ( i+1 < input_length ) {
        //             str += ',';
        //         }
        //         // alert( result ); // 未完待续
        //     });

        //     if ( result == false ) { return false; } 

        //     return '{'+str+'}';

        // }
 
        // function getFromAllData () {

        //     var str = '';
        //     var value = '';
        //     var fomObj = $('from');
        //     var value = new Array();
        //     var input_length = fomObj.length;

        //     fomObj.each(function(i){

        //         value = getFromData( $(this).attr('id') );

        //         if ( value == false ) {
        //             result = false;
        //         }

        //         str += value;

        //         if ( i+1 < input_length ) {
        //             str += ',';
        //         }

        //     });

        //     if ( result == false ) { return false };
        //     // return JSON.stringify('['+str+']');
        //     return '['+str+']';
        // }

        // function submitAjax( str, url ) { 
        //     $.ajax({
        //         type: "POST",
        //         dataType: "json",
        //         url: url,
        //         data: str,
        //         // traditional: true,
        //         success: function (data) {

        //             alert(JSON.stringify(data))
        //             alert( data.sqlserver );
        //             // if ( data = true )
        //             // console.log(result);    //打印服务端返回的数据(调试用)
        //             // if (result.resultCode == 200) {
        //             //     alert("SUCCESS");
        //             // }; 
        //             // alert(data.username);
        //         },
        //         error : function() {
        //             alert("提交异常！");
        //         }
        //     });
        // }

    

