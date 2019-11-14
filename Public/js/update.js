

var Update = function( url, id ) {
    this.url = url;
    this.id = id;
    this.is_submit();
}

Update.prototype = {

    is_submit:function() {
        typeof( this.id ) !== 'undefined' ? this.linkData() : this.linkDataAll();
    },


    linkData:function() {

        var str = this.getFromData( this.id );
        str === false ? this.updateMessage( '信息输入不完整' ) : new SendAjax( this.url, str );
        
    },


    linkDataAll:function() {
        var str = this.getFromAllData();
        str === false ? this.updateMessage( '信息输入不完整' ) : new SendAjax( this.url, str );
        // window.parent.aa = str;
    },


    getFromData:function( id ) {

        var str = '';
        var input_Obj = $( "#"+id ).find( "input:text" );
        var result = true;
        var input_length = input_Obj.length;

        input_Obj.each(function(i){

            var thisName = $(this).attr( 'name' );
            var thisVal = $(this).val();

            if ( thisVal === '' ) {
                $( this ).siblings( 'i' ).css( "color", "red" ).html('必填项');
                result = false;
            } else {
                $( this ).siblings( 'i' ).html('');
            }

            str += '"'+( thisName+'":"'+thisVal )+'"';

            if ( i+1 < input_length ) {
                str += ',';
            }

        });

        return result === false ? false : '{'+str+'}';

    },


    getFromAllData:function() {

        var str = '';
        var value = '';
        var fomObj = $( 'from' );
        var input_length = fomObj.length;
        var result = true;

        fomObj.each( function( i ){

            value = Update.prototype.getFromData( $(this).attr('id') );

            if ( value === false ) {
                result = false;
            }

            str += value;

            if ( i+1 < input_length ) {
                str += ',';
            }

        });

        return result === false ? false : '['+str+']';
        // return JSON.stringify('['+str+']');

    },


    updateMessage:function( str ) {
        alert( str );
    }


}


