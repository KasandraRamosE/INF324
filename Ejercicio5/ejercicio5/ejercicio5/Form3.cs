using System;
using System.Data;
using System.Data.SqlClient;
using System.Windows.Forms;

namespace ejercicio5
{
    public partial class Form3 : Form
    {
        DataSet ds = new DataSet();  // Crear un DataSet para manejar los datos
        SqlDataAdapter adaPropiedad; // SqlDataAdapter para la tabla propiedad
        SqlConnection con;  // Conexión a la base de datos

        public Form3()
        {
            InitializeComponent();
            dataGridView1.RowValidated += dataGridView1_RowValidated;
        }

        private void Form3_Load(object sender, EventArgs e)
        {
            CargarDatosPropiedad();
        }

        private void CargarDatosPropiedad()
        {
            try
            {
                con = new SqlConnection("server=(local);database=BDKasandra;Integrated Security=True;");

                // Consulta con JOIN para mostrar el CI del propietario
                string query = @"
                    SELECT 
                        p.id, 
                        per.ci AS Propietario_CI, 
                        p.zona, 
                        p.xini, 
                        p.yini, 
                        p.xfin, 
                        p.yfin, 
                        p.superficie, 
                        p.distrito 
                    FROM 
                        propiedad p 
                    INNER JOIN 
                        persona per 
                    ON 
                        p.id_propietario = per.id";

                adaPropiedad = new SqlDataAdapter(query, con);
                adaPropiedad.Fill(ds, "propiedad");

                dataGridView1.DataSource = ds;
                dataGridView1.DataMember = "propiedad";

                dataGridView1.Columns["Propietario_CI"].HeaderText = "CI Propietario";
            }
            catch (Exception ex)
            {
                MessageBox.Show("Error al cargar los datos: " + ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        // Evento que se dispara al validar una fila en el DataGridView
        private void dataGridView1_RowValidated(object sender, DataGridViewCellEventArgs e)
        {
            dataGridView1.EndEdit();
            GuardarCambiosPropiedad();
        }

        // Método para guardar los cambios en la tabla propiedad
        private void GuardarCambiosPropiedad()
        {
            try
            {
                if (ds.Tables["propiedad"].GetChanges() != null)
                {
                    foreach (DataRow fila in ds.Tables["propiedad"].Rows)
                    {
                        if (fila.RowState == DataRowState.Modified)
                        {
                            using (SqlCommand cmd = new SqlCommand("UPDATE propiedad SET zona=@zona, xini=@xini, yini=@yini, xfin=@xfin, yfin=@yfin, superficie=@superficie, distrito=@distrito WHERE id=@id", con))
                            {
                                cmd.Parameters.AddWithValue("@zona", fila["zona"]);
                                cmd.Parameters.AddWithValue("@xini", fila["xini"]);
                                cmd.Parameters.AddWithValue("@yini", fila["yini"]);
                                cmd.Parameters.AddWithValue("@xfin", fila["xfin"]);
                                cmd.Parameters.AddWithValue("@yfin", fila["yfin"]);
                                cmd.Parameters.AddWithValue("@superficie", fila["superficie"]);
                                cmd.Parameters.AddWithValue("@distrito", fila["distrito"]);
                                cmd.Parameters.AddWithValue("@id", fila["id"]);

                                con.Open();
                                cmd.ExecuteNonQuery();
                                con.Close();
                            }
                        }
                    }

                    ds.Tables["propiedad"].AcceptChanges();
                    MessageBox.Show("Cambios guardados en la tabla propiedad", "Información", MessageBoxButtons.OK, MessageBoxIcon.Information);
                }
            }
            catch (DBConcurrencyException ex)
            {
                MessageBox.Show("Error de concurrencia: " + ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            catch (Exception ex)
            {
                MessageBox.Show("Error al guardar los cambios: " + ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        // Evento del botón para eliminar la fila seleccionada
        private void button1_Click(object sender, EventArgs e)
        {
            try
            {
                // Verificar que haya una fila seleccionada
                if (dataGridView1.SelectedRows.Count > 0)
                {
                    // Obtener el ID de la fila seleccionada
                    int filaSeleccionada = dataGridView1.SelectedRows[0].Index;
                    int idPropiedad = Convert.ToInt32(dataGridView1.Rows[filaSeleccionada].Cells["id"].Value);

                    // Preguntar al usuario si desea eliminar la fila
                    var confirmResult = MessageBox.Show("¿Está seguro de que desea eliminar esta propiedad?", "Confirmar eliminación", MessageBoxButtons.YesNo, MessageBoxIcon.Question);
                    if (confirmResult == DialogResult.Yes)
                    {
                        // Eliminar de la base de datos
                        using (SqlCommand cmd = new SqlCommand("DELETE FROM propiedad WHERE id=@id", con))
                        {
                            cmd.Parameters.AddWithValue("@id", idPropiedad);
                            con.Open();
                            cmd.ExecuteNonQuery();
                            con.Close();
                        }

                        // Eliminar la fila del DataSet y del DataGridView
                        ds.Tables["propiedad"].Rows[filaSeleccionada].Delete();
                        ds.Tables["propiedad"].AcceptChanges();

                        MessageBox.Show("Propiedad eliminada con éxito.", "Eliminación Exitosa", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    }
                }
                else
                {
                    MessageBox.Show("Seleccione una fila para eliminar.", "Advertencia", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Error al eliminar la propiedad: " + ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
                con.Close();
            }
        }
    }
}

