using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace Metods
{
    public partial class Form2 : Form
    {
        public Form2()
        {
            InitializeComponent();
        }

        private List<double> xValues = new List<double> { 1.0, 2.0, 3.0, 4.0 };
        private List<double> yValues = new List<double> { 2.0, 3.0, 5.0, 7.0 };


        private void Form2_Load(object sender, EventArgs e)
        {

        }

        private void button1_Click(object sender, EventArgs e)
        {
            try
            {
                // Пример чтения значения x* из текстового поля
                double xStar = double.Parse(textBoxXStar.Text);

                // Вычисляем значение полинома Лагранжа
                double lagrangeValue = LagrangeInterpolation(xValues, yValues, xStar);

                // Вычисляем значение полинома Ньютона
                double newtonValue = NewtonInterpolation(xValues, yValues, xStar);

                // Выводим результат на форму
                labelResultLagrange.Text = $"Lagrange P(x*) = {lagrangeValue}";
                labelResultNewton.Text = $"Newton   P(x*) = {newtonValue}";
            }
            catch (Exception ex)
            {
                MessageBox.Show($"Ошибка: {ex.Message}");
            }
        }

        /// <summary>
        /// Метод для вычисления значения интерполяционного многочлена Лагранжа в точке xStar.
        /// </summary>
        /// <param name="xs">Список узловых точек x_i.</param>
        /// <param name="ys">Список значений функции y_i в узлах.</param>
        /// <param name="xStar">Точка, в которой вычисляем значение полинома.</param>
        /// <returns>Значение полинома Лагранжа в точке xStar.</returns>

        private double LagrangeInterpolation(List<double> xs, List<double> ys, double xStar)
        {
            int n = xs.Count;
            double result = 0.0;

            for (int i = 0; i < n; i++)
            {
                // Базисный полином l_i(x)
                double term = ys[i];
                for (int j = 0; j < n; j++)
                {
                    if (j != i)
                    {
                        term *= (xStar - xs[j]) / (xs[i] - xs[j]);
                    }
                }
                result += term;
            }

            return result;
        }

        private double NewtonInterpolation(List<double> xs, List<double> ys, double xStar)
        {
            int n = xs.Count;
            // Матрица для разделённых разностей: 
            // divDiff[i, j] — это значение j-й разделённой разности в точке i.
            double[,] divDiff = new double[n, n];

            // Заполняем нулевую колонку (нулевые разности — это сами значения функции)
            for (int i = 0; i < n; i++)
            {
                divDiff[i, 0] = ys[i];
            }

            // Вычисляем разделённые разности по формуле:
            // divDiff[i, j] = (divDiff[i+1, j-1] - divDiff[i, j-1]) / (xs[i+j] - xs[i])
            for (int j = 1; j < n; j++)
            {
                for (int i = 0; i < n - j; i++)
                {
                    divDiff[i, j] = (divDiff[i + 1, j - 1] - divDiff[i, j - 1]) / (xs[i + j] - xs[i]);
                }
            }

            // Теперь строим полином Ньютона:
            // P(x) = divDiff[0, 0] 
            //       + divDiff[0, 1]*(x - x0) 
            //       + divDiff[0, 2]*(x - x0)*(x - x1) + ...
            double result = divDiff[0, 0];
            double product = 1.0;

            for (int k = 1; k < n; k++)
            {
                product *= (xStar - xs[k - 1]);
                result += divDiff[0, k] * product;
            }

            return result;
        }
    }
}
