function autofillpatient(element)
{
    document.getElementById("patient_id").value=$(element). children("option:selected"). val();
    document.getElementById("patient_name").value=$(element). children("option:selected"). attr("p_name");
}
function autofilltechnician(element)
{
    document.getElementById("technician_name").value=$(element). children("option:selected"). val();
}
function dynamicpost(r_id,p_id,d_id,a_id)
{
    path = "view_report.php";
    // params = "report_id="+r_id+"&user_id="+p_id+"&doctor_id="+d_id+"&id="+a_id;
    params = {report_id:r_id,user_id:p_id,doctor_id:d_id,id:a_id};
    post(path,params);
    

}
function post(path, params, method='post') {

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    const form = document.createElement('form');
    form.method = "dynamic_submit";
    form.method = method;
    form.action = path;
  
    for (const key in params) {
      if (params.hasOwnProperty(key)) {
        const hiddenField = document.createElement('input');
        hiddenField.type = 'hidden';
        hiddenField.name = key;
        hiddenField.value = params[key];
  
        form.appendChild(hiddenField);
      }
    }
  
    document.body.appendChild(form);
    form.submit();
  }