using System;
using System.Data;
using System.Data.SqlClient;
using System.Windows.Forms;

namespace ejercicio5
{
    public partial class Form1 : Form
    {
        // Conexión a la base de datos
        SqlConnection con = new SqlConnection("server=(local);database=BDKasandra;Integrated Security=True;");

        public Form1()
        {
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            // Obtener los valores ingresados por el usuario en los TextBox
            string usuario = textBox1.Text.Trim();
            string contraseña = textBox2.Text.Trim();

            // Validar que los campos no estén vacíos
            if (string.IsNullOrEmpty(usuario) || string.IsNullOrEmpty(contraseña))
            {
                MessageBox.Show("Por favor, ingrese un usuario y una contraseña válidos.", "Campos Vacíos", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }

            try
            {
                con.Open();

                // Definir la consulta para verificar si el administrador existe
                string queryAdmin = "SELECT id FROM administrador WHERE usuario=@usuario AND contraseña=@contraseña";

                // Crear y ejecutar el comando para la tabla "administrador"
                SqlCommand cmd = new SqlCommand(queryAdmin, con);
                cmd.Parameters.AddWithValue("@usuario", usuario);
                cmd.Parameters.AddWithValue("@contraseña", contraseña);

                SqlDataReader reader = cmd.ExecuteReader();

                // Verificar si las credenciales coinciden en la tabla administrador
                if (reader.HasRows)
                {
                    reader.Close();
                    con.Close();

                    MessageBox.Show("Inicio de sesión como administrador exitoso. ¡Bienvenido!", "Éxito", MessageBoxButtons.OK, MessageBoxIcon.Information);

                    // Crear una instancia de Form2 (para el administrador) y mostrarlo
                    Form2 frm = new Form2();
                    this.Hide();  // Ocultar el formulario actual (Form1)
                    frm.Show();   // Mostrar Form2
                }
                else
                {
                    // Si no coincide con la tabla administrador, verificar en la tabla "persona"
                    reader.Close(); // Cerrar el primer SqlDataReader

                    // Definir la consulta para verificar si el usuario existe en la tabla "persona"
                    string queryPersona = "SELECT id FROM persona WHERE usuario=@usuario AND contraseña=@contraseña";

                    SqlCommand cmdPersona = new SqlCommand(queryPersona, con);
                    cmdPersona.Parameters.AddWithValue("@usuario", usuario);
                    cmdPersona.Parameters.AddWithValue("@contraseña", contraseña);

                    SqlDataReader readerPersona = cmdPersona.ExecuteReader();

                    if (readerPersona.HasRows)
                    {
                        readerPersona.Read();  // Leer la fila para obtener el ID del usuario
                        int idPersona = readerPersona.GetInt32(0);  // Obtener el ID de la persona

                        readerPersona.Close();
                        con.Close();

                        MessageBox.Show("Inicio de sesión como persona exitoso. ¡Bienvenido!", "Éxito", MessageBoxButtons.OK, MessageBoxIcon.Information);

                        // Crear una instancia de Form5 (para el usuario de la tabla "persona") y pasarle el ID de la persona
                        Form5 frmPersona = new Form5(idPersona);
                        this.Hide();  // Ocultar el formulario actual (Form1)
                        frmPersona.Show();   // Mostrar Form5 con el ID del usuario
                    }
                    else
                    {
                        // Si las credenciales no corresponden a ninguna tabla, mostrar un mensaje de error
                        readerPersona.Close();
                        con.Close();
                        MessageBox.Show("Usuario o contraseña incorrectos. Intente de nuevo.", "Error de Autenticación", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    }
                }
            }
            catch (Exception ex)
            {
                // Mostrar un mensaje de error en caso de fallos de conexión o de consulta
                MessageBox.Show("Error al conectar a la base de datos: " + ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
    }
}
