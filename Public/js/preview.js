
var Preview = function( url, zipId ) 
{
    this.url = url;
    this.zipId = zipId;
    alert(this.url);
    this.statPreview();
}

Preview.prototype = {

    statPreview:function() {
        var str = this.getFromAllData();
        new SendAjax( this.url, str );
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

        return result === false ? false : '[{"zipid":"'+this.zipId+'"},'+str+']';
        // return JSON.stringify('['+str+']');

    },

}

