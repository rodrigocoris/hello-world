const apiEndpoint = plansURL;
const plansContainer = document.getElementById('plans-container');
let basicPlan, vipPlanMonthly, vipPlanYearly, otherPlans = [];

// Function to fetch and display subscription plans
async function loadPlans() {
    try {
        const response = await fetch(apiEndpoint);
        const plans = await response.json();

        plans.forEach(plan => {
            if (plan.name.includes('Básico')) {
                basicPlan = plan;
            } else if (plan.name.includes('VIP')) {
                if (plan.frequency === 'monthly') {
                    vipPlanMonthly = plan;
                } else if (plan.frequency === 'yearly') {
                    vipPlanYearly = plan;
                }
            } else {
                otherPlans.push(plan);
            }
        });

        // Display plans in the desired order
        if (basicPlan) plansContainer.appendChild(createPlanElement(basicPlan));
        if (vipPlanMonthly && vipPlanYearly) plansContainer.appendChild(createVipPlanElement(vipPlanMonthly, vipPlanYearly));
        otherPlans.forEach(plan => plansContainer.appendChild(createPlanElement(plan)));

    } catch (error) {
        console.error('Error fetching plans:', error);
    }
}

// Function to create a plan element
function createPlanElement(plan) {
    const benefits = JSON.parse(plan.benefits).benefits.map(benefit =>
        `<li><p class="ff-Helvetica"><i class="fa-regular fa-circle-check color-13"></i> ${benefit}</p></li>`
    ).join('');

    const planColumn = document.createElement('div');
    planColumn.className = 'plan-column';
    planColumn.innerHTML = `
            <h2 class="h2-f1 fw-normal mg-bottom-50">${plan.role_name}</h2>
            <div style="display: flex;">
                <h2 class="h2-f1 fw-normal">${plan.currency === 'USD' ? '$' : ''}${plan.price}</h2>
                <span class="currency-style">${plan.currency === 'USD' ? 'usd' : ''}</span>
                <div class="landing-plan-switch">
                    <div class="form-check form-switch d-flex">
                        <p class="checkable-text mt-2"><b>${ plan.role_name !== "Básico" ? (plan.frequency === 'monthly' ? 'Mensual' : 'Anual') : '' }</b></p>
                    </div>
                </div>
            </div>
            <p class="ff-Helvetica">${plan.description}</p>
            <button class="button-12 ff-Inter fw-bolder mg-top-25 mg-bottom-25" onclick="redirectTo('registro')">¡Empezar Ahora!</button>
            <h4 class="ff-Inter fw-bolder">El plan incluye:</h4>
            <ul class="plan-content-list">
                ${benefits}
            </ul>
        `;
    return planColumn;
}

// Function to create the VIP plan element with a toggle switch
function createVipPlanElement(monthlyPlan, yearlyPlan) {
    const monthlyBenefits = JSON.parse(monthlyPlan.benefits).benefits.map(benefit =>
        `<li><p class="ff-Helvetica"><i class="fa-regular fa-circle-check color-13"></i> ${benefit}</p></li>`
    ).join('');
    const yearlyBenefits = JSON.parse(yearlyPlan.benefits).benefits.map(benefit =>
        `<li><p class="ff-Helvetica"><i class="fa-regular fa-circle-check color-13"></i> ${benefit}</p></li>`
    ).join('');

    const planColumn = document.createElement('div');
    planColumn.className = 'plan-column border-selected-1';
    planColumn.innerHTML = `
            <h2 class="h2-f1 fw-normal mg-bottom-50 color-2">${monthlyPlan.role_name}</h2>
            <div style="display: flex;">
                <h2 id="vip-price" class="h2-f1 fw-normal color-2">${monthlyPlan.currency === 'USD' ? '$' : ''}${monthlyPlan.price}</h2>
                <span class="currency-style">${monthlyPlan.currency === 'USD' ? 'usd' : ''}</span>
                <div class="landing-plan-switch">
                    <div class="form-check form-switch d-flex">
                        <p class="checkable-text mt-1"><b>Mensual</b></p>
                        <input class="form-check-input ms-2 custom-switch-2" type="checkbox" role="switch" id="flexSwitchCheckVip" onchange="toggleVipPlan()">
                        <p class="checkable-text mt-1 ms-2"><b>Anual</b></p>
                    </div>
                </div>
            </div>
            <p id="vip-description" class="ff-Helvetica">${monthlyPlan.description}</p>
            <button class="button-13 ff-Inter fw-bolder mg-top-25 mg-bottom-25" onclick="redirectTo('registro')">¡Empezar Ahora!</button>
            <h4 class="ff-Inter fw-bolder">El plan incluye:</h4>
            <ul id="vip-benefits" class="plan-content-list">
                ${monthlyBenefits}
            </ul>
        `;
    return planColumn;
}

// Function to toggle between monthly and yearly VIP plans
function toggleVipPlan() {
    const isChecked = document.getElementById('flexSwitchCheckVip').checked;
    const priceElement = document.getElementById('vip-price');
    const descriptionElement = document.getElementById('vip-description');
    const benefitsElement = document.getElementById('vip-benefits');

    const theadPriceElement = document.getElementById('vip-thead-price');
    const theadDurationElement = document.getElementById('vip-thead-duration');

    if (isChecked) {
        priceElement.textContent = `${vipPlanYearly.currency === 'USD' ? '$' : ''}${vipPlanYearly.price}`;
        descriptionElement.textContent = vipPlanYearly.description;
        benefitsElement.innerHTML = JSON.parse(vipPlanYearly.benefits).benefits.map(benefit =>
            `<li><p class="ff-Helvetica"><i class="fa-regular fa-circle-check color-13"></i> ${benefit}</p></li>`
        ).join('');
        theadPriceElement.textContent = `${vipPlanYearly.currency === 'USD' ? '$' : ''}${vipPlanYearly.price}`;
        theadDurationElement.textContent = 'Año';

    } else {
        priceElement.textContent = `${vipPlanMonthly.currency === 'USD' ? '$' : ''}${vipPlanMonthly.price}`;
        descriptionElement.textContent = vipPlanMonthly.description;
        benefitsElement.innerHTML = JSON.parse(vipPlanMonthly.benefits).benefits.map(benefit =>
            `<li><p class="ff-Helvetica"><i class="fa-regular fa-circle-check color-13"></i> ${benefit}</p></li>`
        ).join('');
        theadPriceElement.textContent = `${vipPlanMonthly.currency === 'USD' ? '$' : ''}${vipPlanMonthly.price}`;
        theadDurationElement.textContent = 'Mes';

    }
}

// Utility function to capitalize the first letter of a string
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

// Load the plans on page load
loadPlans();