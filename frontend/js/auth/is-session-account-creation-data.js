document.addEventListener('DOMContentLoaded', function() {
    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            if(session_plan_id == 3) {
                renderSubscriptionPlans(data, 2);
                document.getElementById("flexSwitchCheckVip2").checked = true;
                toggleVipPlan(2);
            } else {
                renderSubscriptionPlans(data, session_plan_id);
            }
        })
        .catch(error => {
            console.error('Error fetching subscription plans:', error);
        });
});