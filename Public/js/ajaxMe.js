
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
                // var dataLength = Object.keys(data).length;
                // alert( this.url );
                // alert(data.code);
                if ( data.code == 200 ) {
                    SendAjax.prototype.ajaxSingle( data.data );    
                } else if ( data.code == 201 ) {
                    alert( 'abc' );
                }

            },
            error : function() {
                alert("提交异常！");
            }
        });
    },

    ajaxSingle:function( data ) {

        var status = true;
        var num = 0;

        $.each( data, function( k, v ){

            $(".li_o .type").each(function(){
                var thisText = $.trim( $(this).text() );
                var str = new RegExp(k);
                if ( str.test(thisText) ) {
                    if ( v === false ) {
                        $(this).css( 'color', 'red' );
                        $(this).html( k+' 连接失败' );
                        status = false;
                    } else {
                        num += 1;
                        $(this).css( 'color', 'blue' );
                        $(this).html( k+' 连接成功' );
                    }
                }
            });

        });
        
        var dataLength = $(".li_o  .type").length;

        if ( status === false ) {
            $( '#preview' ).css( 'background', 'gray' );
            alert( '连接失败' );
        } else if ( dataLength !== num ){
            alert( '连接成功' );
        } else {
            $( '#preview' ).css( 'background', '#ea68a2' );
            alert( '全部连接成功' );
            
        }

    },



    // ajaxMore:function( data ) {
    //     alert(data);
    //     $.each( data, function( k, v ){

    //         $(".li_o .type").each(function(){
    //             var thisText = $.trim( $(this).text() );
    //             var str = new RegExp(k);
    //             if ( str.test(thisText) ) {
    //                 if ( v === false ) {
    //                     $(this).css( 'color', 'red' );
    //                     $(this).html( k+' 连接失败' );
    //                 } else {
    //                     $(this).css( 'color', 'blue' );
    //                     $(this).html( k );
    //                 }
    //             }
    //         });

    //     });
    // }

}

