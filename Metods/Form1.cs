using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using ZedGraph;

namespace Metods
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
            InitializeDataGridView();

        }


        private void btnLagrange_Click(object sender, EventArgs e)
        {
            int rowCount = dataGridView1.RowCount;
            double[] x = new double[rowCount];
            double[] y = new double[rowCount];

            for (int i = 0; i < rowCount; i++)
            {
                double.TryParse(dataGridView1.Rows[i].Cells[0].Value?.ToString(), out x[i]);
                double.TryParse(dataGridView1.Rows[i].Cells[1].Value?.ToString(), out y[i]);
            }
            try
            {
                double xStar = double.Parse(txtXStar.Text);
                double result = LagrangeInterpolation(x, y, xStar);
            }
            catch (Exception ex)
            {
                MessageBox.Show("Введите значение интерполяционных многочленов в точке x*.", "ERROR");
            }
        }

        private void btnNewton_Click(object sender, EventArgs e)
        {
            int rowCount = dataGridView1.RowCount;
            double[] x = new double[rowCount];
            double[] y = new double[rowCount];

            for (int i = 0; i < rowCount; i++)
            {
                double.TryParse(dataGridView1.Rows[i].Cells[0].Value?.ToString(), out x[i]);
                double.TryParse(dataGridView1.Rows[i].Cells[1].Value?.ToString(), out y[i]);
            }
            try
            {
                double xStar = double.Parse(txtXStar.Text);
                double result = NewtonInterpolation(x, y, xStar);
            }
            catch (Exception ex)
            {
                MessageBox.Show("Введите значение интерполяционных многочленов в точке x*.", "ERROR");
            }
        }

        private double LagrangeInterpolation(double[] x, double[] y, double xStar)
        {
            int n = x.Length - 1;
            double resultValue = 0;
            string result = "";

            for (int i = 0; i < n; i++)
            {
                double term = y[i];
                string termDetails = $"L{i}({xStar}) = {y[i]} * ";

                for (int j = 0; j < n; j++)
                {
                    if (i != j)
                    {
                        term *= (xStar - x[j]) / (x[i] - x[j]);
                        termDetails += $"(({xStar} - {x[j]}) / ({x[i]} - {x[j]})) * ";
                    }
                }

                resultValue += term;
                result += termDetails + $"= {term}\n";
            }

            result += $"L({xStar}) = ";
            foreach (double term in y)
            {
                result += $"{term} * L_i({xStar}) + ";
            }
            result += $"= {resultValue}\n";

            richTextBox1.Clear();
            richTextBox1.AppendText("Интерполяция Лагранжа:\n");
            richTextBox1.AppendText(result + "\n");
            return 0;
        }

        private double NewtonInterpolation(double[] x, double[] y, double xStar)
        {
            int n = x.Length - 1;
            double[,] f = new double[n, n];
            string result = "";

            for (int i = 0; i < n; i++)
            {
                f[i, 0] = y[i];
                result += $"f[{i}, 0] = {f[i, 0]}\n";
            }

            for (int i = 1; i < n; i++)
            {
                for (int j = 0; j < n - i; j++)
                {
                    f[j, i] = (f[j + 1, i - 1] - f[j, i - 1]) / (x[j + i] - x[j]);
                    result += $"f[{j}, {i}] = ({f[j + 1, i - 1]} - {f[j, i - 1]}) / ({x[j + i]} - {x[j]}) = {f[j, i]}\n";
                }
            }

            result += $"P({xStar}) = ";
            double value = f[0, 0];
            result += $"{value} ";
            double u = 1;
            for (int i = 1; i < n; i++)
            {
                u *= (xStar - x[i - 1]);
                value += f[0, i] * u;
                result += $"+ {f[0, i]} * {u} ";
            }

            result += $"= {value}\n";
            richTextBox1.Clear();
            richTextBox1.AppendText("Интереполяция Ньютона:\n");
            richTextBox1.AppendText(result + "\n");
            return 0;
        }

        private void InitializeDataGridView()
        {
            dataGridView1.Columns.Add("X", "X");
            dataGridView1.Columns.Add("Y", "Y");
        }

        private void dataGridView1_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {

        }

        private void button1_Click(object sender, EventArgs e)
        {
            int rowCount = dataGridView1.RowCount;
            double[] x = new double[rowCount];
            double[] y = new double[rowCount];

            for (int i = 0; i < rowCount; i++)
            {
                double.TryParse(dataGridView1.Rows[i].Cells[0].Value?.ToString(), out x[i]);
                double.TryParse(dataGridView1.Rows[i].Cells[1].Value?.ToString(), out y[i]);
            }

            // Построение графиков
            PlotGraph(zedGraphControl1, x, y);
        }

        private void PlotGraph(ZedGraphControl zedGraph, double[] x, double[] y)
        {
            GraphPane pane = zedGraph.GraphPane;
            pane.CurveList.Clear();

            // Исходные точки
            PointPairList list = new PointPairList();
            for (int i = 0; i < x.Length; i++)
            {
                list.Add(x[i], y[i]);
            }
            LineItem curve = pane.AddCurve("Исходные точки", list, Color.Blue, SymbolType.Circle);

            // Интерполяционный полином
            double[] xInterp = GenerateInterpolationPoints(x, 100);
            double[] yInterp = new double[xInterp.Length];
            for (int i = 0; i < xInterp.Length; i++)
            {
                yInterp[i] = LagrangeInterpolation(x, y, xInterp[i]);
            }
            PointPairList interpList = new PointPairList(xInterp, yInterp);
            LineItem interpCurve = pane.AddCurve("Интерполяция", interpList, Color.Red, SymbolType.None);

            zedGraph.AxisChange();
            zedGraph.Invalidate();
        }

        private double[] GenerateInterpolationPoints(double[] x, int count)
        {
            double min = x[0];
            double max = x[x.Length - 1];
            double[] result = new double[count];
            double step = (max - min) / (count - 1);
            for (int i = 0; i < count; i++)
            {
                result[i] = min + i * step;
            }
            return result;

        }

        private void groupBox1_Enter(object sender, EventArgs e)
        {

        }
    }
}
