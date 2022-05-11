using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Xamarin.Forms;
using ProjetBiblioquokka;

namespace ProjetBiblioquokka
{
    public partial class MainPage : ContentPage
    {
        public MainPage()
        {
            InitializeComponent();
        }

        //Fonction permettant d'aller sur la page d'inscription (désactivé)
        public void NavigateToInscript(object sender, EventArgs e)
        {
            App.Current.MainPage = (new register());
        }

        //Fonction qui déclanche la connexion
        public void Login(object sender, EventArgs e)
        {
            string newPass = new Api().PassHash(password.Text, mail.Text);

            int isLogged = new Api().Login(mail.Text, newPass);
            if (isLogged == 0)
            {
                errorDisp.Text = "Utilise un vrai compte";
            }
            else
            {
                App.Current.MainPage = (new Acceuil(isLogged));
            }
        }

        //Fonction permettant de bypass la connexion (dev uniquement)
        public void BypassLogin(object sender, EventArgs e) {
            App.Current.MainPage = (new Acceuil(1));
        }
    }

}
