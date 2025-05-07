<script>
    function GetCityByPinCode(name, pincode, count) {
        var state = '#' + name + 'AddState';
        var district = '#' + name + 'AddDistrict';
        var pincodeMsg = '#' + name + 'pincodeMsg';
        var city = '#' + name + 'AddCity';

        if (pincode.length != 6) {

            $(pincodeMsg + count).text('Pincode may not less/greater than 6 digits');
            $(pincodeMsg + count).show();
            $(state + count).val('');
            $(district + count).val('');
            $(city + count).val('');
        }
        if (pincode.length == 6 && $.isNumeric(pincode)) {
            $.ajax({
                url: '/pincode/' + pincode,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    if (data.state.length == 0) {

                        $(pincodeMsg + count).text('Pincode not found');
                        $(pincodeMsg + count).show();

                    } else {
                         $(pincodeMsg + count).hide();
                        $(state + count).val(data.state)
                        $(district + count).val(data.district);
                        // $(city + count).empty();
                        // Populate city dropdown
                        data.city.forEach(function(cityName) {
                            $(city + count).append('<option value="' + cityName + '">' + cityName + '</option>');
                        });

                    }

                }
            });
        };
    }
</script>