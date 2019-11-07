
var SendAjax = function( url, data ) 
{
    this.url = url;
    this.data = data;
    this.submitAjax();
}

SendAjax.prototype = {

    submitAjax:function() { 
        $.ajax({
            type: "POST",
            dataType: "json",
            url: this.url,
            data: this.data,
            success: function ( data ) {

                switch( Object.keys(data).length ) {
                    case 1:
                       SendAjax.prototype.ajaxb( data );
                       break;
                    case 2:
                       alert( 'hello word!' );
                       break;
                    default:
                       alert('啥也没有啊');
                } 


                // var num = Object.keys(data).length;
                // if ( num === 1 ) {
                //     SendAjax.prototype.ajaxb( data );
                // }
                // return result;
                // alert( JSON.stringify( result ));
                // alert( result.sqlserver );
                // if ( data = true )
                // console.log(result);    //打印服务端返回的数据(调试用)
                // if (result.resultCode == 200) {
                //     alert("SUCCESS");
                // }; 
                // alert(data.username);
                未完待续
            },
            error : function() {
                alert("提交异常！");
            }
        });
    },

    ajaxb:function( data ) {
        alert( JSON.stringify( data ) );
        alert( 213123 );
    }

}

