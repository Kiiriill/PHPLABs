﻿namespace Metods
{
    partial class Form2
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            this.button1 = new System.Windows.Forms.Button();
            this.button2 = new System.Windows.Forms.Button();
            this.textBoxXStar = new System.Windows.Forms.TextBox();
            this.labelResultLagrange = new System.Windows.Forms.Label();
            this.labelResultNewton = new System.Windows.Forms.Label();
            this.SuspendLayout();
            // 
            // button1
            // 
            this.button1.Location = new System.Drawing.Point(56, 70);
            this.button1.Name = "button1";
            this.button1.Size = new System.Drawing.Size(75, 23);
            this.button1.TabIndex = 0;
            this.button1.Text = "button1";
            this.button1.UseVisualStyleBackColor = true;
            this.button1.Click += new System.EventHandler(this.button1_Click);
            // 
            // button2
            // 
            this.button2.Location = new System.Drawing.Point(215, 70);
            this.button2.Name = "button2";
            this.button2.Size = new System.Drawing.Size(75, 23);
            this.button2.TabIndex = 1;
            this.button2.Text = "button2";
            this.button2.UseVisualStyleBackColor = true;
            // 
            // textBoxXStar
            // 
            this.textBoxXStar.Location = new System.Drawing.Point(66, 121);
            this.textBoxXStar.Name = "textBoxXStar";
            this.textBoxXStar.Size = new System.Drawing.Size(100, 20);
            this.textBoxXStar.TabIndex = 2;
            // 
            // labelResultLagrange
            // 
            this.labelResultLagrange.AutoSize = true;
            this.labelResultLagrange.Location = new System.Drawing.Point(66, 183);
            this.labelResultLagrange.Name = "labelResultLagrange";
            this.labelResultLagrange.Size = new System.Drawing.Size(35, 13);
            this.labelResultLagrange.TabIndex = 3;
            this.labelResultLagrange.Text = "label1";
            // 
            // labelResultNewton
            // 
            this.labelResultNewton.AutoSize = true;
            this.labelResultNewton.Location = new System.Drawing.Point(66, 222);
            this.labelResultNewton.Name = "labelResultNewton";
            this.labelResultNewton.Size = new System.Drawing.Size(35, 13);
            this.labelResultNewton.TabIndex = 4;
            this.labelResultNewton.Text = "label2";
            // 
            // Form2
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(800, 521);
            this.Controls.Add(this.labelResultNewton);
            this.Controls.Add(this.labelResultLagrange);
            this.Controls.Add(this.textBoxXStar);
            this.Controls.Add(this.button2);
            this.Controls.Add(this.button1);
            this.Name = "Form2";
            this.Text = "Form2";
            this.Load += new System.EventHandler(this.Form2_Load);
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.Button button1;
        private System.Windows.Forms.Button button2;
        private System.Windows.Forms.TextBox textBoxXStar;
        private System.Windows.Forms.Label labelResultLagrange;
        private System.Windows.Forms.Label labelResultNewton;
    }
}