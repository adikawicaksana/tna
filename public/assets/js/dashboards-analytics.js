/**
 * Dashboard Analytics
 */

'use strict';

(function () {
  let cardColor, headingColor, fontFamily, labelColor;
  cardColor = config.colors.cardColor;
  labelColor = config.colors.textMuted;
  headingColor = config.colors.headingColor;

  const supportTrackerEl = document.querySelector('#supportTracker');
  const totalIncompleteEl = document.querySelector('#total-incomplete');
  const approvedEl = document.querySelector('#approved');
  const submittedEl = document.querySelector('#submitted');

  if (supportTrackerEl || totalIncompleteEl) {
    fetch(urlCompetencyPercentage)
      .then(response => response.json())
      .then(data => {
        const percentage = data.percentage ?? 0;
        const incomplete = data.incomplete ?? 0;

        // Set total incomplete competence ===
        if (totalIncompleteEl) {
          totalIncompleteEl.textContent = incomplete;
        }

        // Render radial bar
        if (totalIncompleteEl) {
          const supportTrackerOptions = {
            series: [percentage],
            labels: ['Kompetensi Terpenuhi'],
            chart: {
              height: 337,
              type: 'radialBar'
            },
            plotOptions: {
              radialBar: {
                offsetY: 10,
                startAngle: -140,
                endAngle: 130,
                hollow: {
                  size: '65%'
                },
                track: {
                  background: cardColor,
                  strokeWidth: '100%'
                },
                dataLabels: {
                  name: {
                    offsetY: -20,
                    color: labelColor,
                    fontSize: '13px',
                    fontWeight: '400',
                    fontFamily: fontFamily
                  },
                  value: {
                    offsetY: 10,
                    color: headingColor,
                    fontSize: '38px',
                    fontWeight: '400',
                    fontFamily: fontFamily
                  }
                }
              }
            },
            colors: [config.colors.primary],
            fill: {
              type: 'gradient',
              gradient: {
                shade: 'dark',
                shadeIntensity: 0.5,
                gradientToColors: [config.colors.primary],
                inverseColors: true,
                opacityFrom: 1,
                opacityTo: 0.6,
                stops: [30, 70, 100]
              }
            },
            stroke: {
              dashArray: 10
            },
            grid: {
              padding: {
                top: -20,
                bottom: 5
              }
            },
            states: {
              hover: {
                filter: {
                  type: 'none'
                }
              },
              active: {
                filter: {
                  type: 'none'
                }
              }
            },
            responsive: [
              {
                breakpoint: 1025,
                options: { chart: { height: 330 } }
              },
              {
                breakpoint: 769,
                options: { chart: { height: 280 } }
              }
            ]
          };

          const supportTracker = new ApexCharts(supportTrackerEl, supportTrackerOptions);
          supportTracker.render();
        }
      })
      .catch(error => console.error('Error fetching percentage:', error));
  }

  fetch(urlIncompleteCompetence)
    .then(response => response.json())
    .then(data => {
      const approved = data.approved ?? 0;
      const submitted = data.submitted ?? 0;

      approvedEl.textContent = approved;
      submittedEl.textContent = submitted;
    })



})();
