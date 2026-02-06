document.addEventListener('DOMContentLoaded', function () {
    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            renderSubscriptionPlans(data);
        })
        .catch(error => {
            console.error('Error fetching subscription plans:', error);
        });
});

function renderSubscriptionPlans(plans, initialPlanId = null) {
    const container = document.getElementById('subscription-plans-container');
    container.innerHTML = '';

    plans.forEach(plan => {
        let perUser = (plan.plan_id === 4) ? ' / 100 licencias' : '';
        let planHtml = `
            <div class="sing-up-checkable-button" id="plan-${plan.plan_id}" onclick="toggleSelectionSingUp('plan-${plan.plan_id}', ${plan.plan_id})">
                <h3 class="h3-f1" id="plan-title-${plan.plan_id}"><i class="fa-solid fa-square-check" id="checked-${plan.plan_id}" style="display: none;"></i> ${plan.name}: $${plan.price}<span style='font-size: 10px;'>${plan.currency}${perUser}</span></h3>
        `;

        if (plan.plan_id === 2) { // VIP Plan
            planHtml += `
                <div class="form-check form-switch d-flex">
                    <p class="checkable-text mt-2"><b>Mensual</b></p>
                    <input class="form-check-input ms-2 custom-switch" type="checkbox" role="switch" id="flexSwitchCheckVip${plan.plan_id}" onchange="toggleVipPlan(${plan.plan_id})">
                    <p class="checkable-text mt-2 ms-2"><b>Anual</b></p>
                </div>
            `;
        }

        planHtml += `<p class="checkable-text">${plan.description}</p>`;
        planHtml += '</div>';

        if (plan.plan_id !== 3 && plan.name !== 'VIP Anual') {
            container.innerHTML += planHtml;
        }
    });

    const moreInfo = document.createElement('p');
    moreInfo.classList.add('more-info-sing-up');
    moreInfo.innerHTML = `<a href="${plansUrl}" target="_blank">Más información</a>`;
    container.appendChild(moreInfo);

    const loginButton = document.createElement('button');
    loginButton.classList.add('button-7');
    loginButton.style.maxWidth = '200px';
    loginButton.style.margin = 'auto';
    loginButton.textContent = 'Iniciar sesión';
    loginButton.onclick = () => redirectTo(loginUrl);
    container.appendChild(loginButton);

    // Initialize the tooltip for the default plan
    hideAllTooltips(); // Ocultar tooltips existentes
    const defaultPlanId = initialPlanId || 1;
    toggleSelectionSingUp(`plan-${defaultPlanId}`, defaultPlanId);
    showTooltip(`plan-${defaultPlanId}`, `Plan ${plans.find(p => p.plan_id === defaultPlanId).name} seleccionado`);
}

function toggleSelectionSingUp(buttonId, userPlan) {
    let buttons = document.getElementsByClassName("sing-up-checkable-button");
    let plan_selected = document.getElementById(`plan-${userPlan}`);

    if (!plan_selected.classList.contains("selected")) {
        for (let i = 0; i < buttons.length; i++) {
            buttons[i].classList.remove("selected");
            let h3Element = buttons[i].querySelector("h3");
            if (h3Element) {
                h3Element.classList.remove("selected");
            }

            let checked = document.getElementById(`checked-${i + 1}`);
            if (checked) {
                checked.style.display = 'none';
            }
        }

        let selectedButton = document.getElementById(buttonId);
        if (selectedButton) {
            selectedButton.classList.add("selected");
            let selectedH3 = selectedButton.querySelector("h3");
            if (selectedH3) {
                selectedH3.classList.add("selected");
            }
        }

        let checked = document.getElementById(`checked-${userPlan}`);
        if (checked) {
            checked.style.display = 'inline-block';
        }

        let planIdElement = document.getElementById("plan_id");
        if (planIdElement) {
            planIdElement.value = userPlan;
        }

        const planName = selectedButton.querySelector('h3').textContent.trim();
        hideAllTooltips();
        showTooltip(buttonId, `${planName} seleccionado`);
    }
}

function showTooltip(elementId, message) {
    hideAllTooltips(); // Asegúrate de destruir tooltips previos
    const element = document.getElementById(elementId);
    if (element) {
        const tooltipInstance = tippy(`#${elementId}`, {
            content: message,
            arrow: true,
            trigger: 'manual',
            placement: 'left',
            theme: 'custom-gradient',
        });

        tooltipInstance[0].show();

        setTimeout(() => {
            tooltipInstance[0].hide();
        }, 5000);
    }
}

tippy.setDefaultProps({
    theme: 'custom-gradient',
});

function hideAllTooltips() {
    document.querySelectorAll('[data-tippy-root]').forEach(tooltip => {
        const instance = tooltip._tippy;
        if (instance) {
            instance.destroy();
        }
    });
}

function toggleVipPlan(planId) {
    const switchElement = document.getElementById(`flexSwitchCheckVip${planId}`);
    const planTitleElement = document.getElementById(`plan-title-${planId}`);
    const isChecked = switchElement.checked;
    let paymentTerm = document.getElementById("payment_term");

    fetch(apiUrl)
        .then(response => response.json())
        .then(plans => {
            const plan = plans.find(p => p.plan_id === planId);
            const alternatePlan = plans.find(p => p.plan_id === 3); // VIP Anual

            if (plan) {
                const selectedPlan = isChecked ? alternatePlan : plan;
                planTitleElement.innerHTML = `
                    <i class="fa-solid fa-square-check" id="checked-${planId}" style="display: inline-block;"></i> 
                    ${selectedPlan.name}: $${selectedPlan.price}
                    <span style='font-size: 10px;'>${selectedPlan.currency}</span>
                `;
                paymentTerm.value = isChecked ? 'yearly' : 'monthly';
            }
        })
        .catch(error => {
            console.error('Error fetching subscription plans:', error);
        });
}
