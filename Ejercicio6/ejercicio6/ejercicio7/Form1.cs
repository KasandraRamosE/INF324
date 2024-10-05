using System;
using System.Data;
using System.Data.SqlClient;
using System.Windows.Forms;

namespace ejercicio7
{
    public partial class Form1 : Form
    {
        SqlConnection con = new SqlConnection("server=(local);database=BDKasandra;Integrated Security=True;");

        public Form1()
        {
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            string usuario = textBox1.Text.Trim();
            string contraseña = textBox2.Text.Trim();

            if (string.IsNullOrEmpty(usuario) || string.IsNullOrEmpty(contraseña))
            {
                MessageBox.Show("Por favor, ingrese un usuario y una contraseña válidos.", "Campos Vacíos", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }

            try
            {
                // Definir la consulta para verificar si el administrador existe
                string query = "SELECT id FROM administrador WHERE usuario=@usuario AND contraseña=@contraseña";

                SqlCommand cmd = new SqlCommand(query, con);
                cmd.Parameters.AddWithValue("@usuario", usuario);
                cmd.Parameters.AddWithValue("@contraseña", contraseña);

                con.Open();
                SqlDataReader reader = cmd.ExecuteReader();

                if (reader.HasRows)
                {
                    // Si las credenciales son correctas, mostrar Form2
                    reader.Close();
                    con.Close();

                    MessageBox.Show("Inicio de sesión exitoso. ¡Bienvenido!", "Éxito", MessageBoxButtons.OK, MessageBoxIcon.Information);

                    // Crear una instancia de Form2 y mostrarlo
                    Form2 frm = new Form2();
                    this.Hide();  // Ocultar el formulario actual (Form1)
                    frm.Show();   // Mostrar el Form2
                }
                else
                {
                    // Si las credenciales son incorrectas, mostrar un mensaje de error
                    MessageBox.Show("Usuario o contraseña incorrectos. Intente de nuevo.", "Error de Autenticación", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }

                con.Close();
            }
            catch (Exception ex)
            {
                MessageBox.Show("Error al conectar a la base de datos: " + ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
    }
}
