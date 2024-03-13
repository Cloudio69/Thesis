Chart.defaults.font.family = "Inter";

const customerData = {
  datasets: [
    {
      backgroundColor: "rgb(54, 162, 235)",
      borderColor: "rgb(54, 162, 235)",
      data: [0],
      fill: false,
    },
  ],
};

const options = {
  plugins: {
    legend: {
      display: false,
    },
  },
  scales: {
    y: {
      min: 0,
      max: 20,
      ticks: {
        stepSize: 1,
      },
    },
  },
};

const contextCustomers = document
  .getElementById("thesis--customers")
  .getContext("2d");
const contextOrders = document
  .getElementById("thesis--orders")
  .getContext("2d");

const customersChart = new Chart(contextCustomers, {
  type: "line",
  data: customerData,
  options: options,
});
const ordersChart = new Chart(contextOrders, {
  type: "line",
  data: customerData,
  options: options,
});
