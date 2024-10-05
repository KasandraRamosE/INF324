using System;
using System.Data;
using System.Data.SqlClient;
using System.Windows.Forms;

namespace ejercicio6
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
                // Definir la consulta para obtener el ID del usuario que inició sesión
                string query = "SELECT id FROM persona WHERE usuario=@usuario AND contraseña=@contraseña";

                SqlCommand cmd = new SqlCommand(query, con);
                cmd.Parameters.AddWithValue("@usuario", usuario);
                cmd.Parameters.AddWithValue("@contraseña", contraseña);

                con.Open();
                SqlDataReader reader = cmd.ExecuteReader();

                if (reader.HasRows)
                {
                    reader.Read();
                    int idUsuario = reader.GetInt32(0); // Obtener el ID del usuario
                    reader.Close();
                    con.Close();

                    MessageBox.Show("Inicio de sesión exitoso. ¡Bienvenido!", "Éxito", MessageBoxButtons.OK, MessageBoxIcon.Information);

                    // Crear una instancia de Form2 y pasar el ID del usuario
                    Form2 frm = new Form2(idUsuario);
                    this.Hide();  // Ocultar el formulario actual (Form1)
                    frm.Show();   // Mostrar el Form2
                }
                else
                {
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
