using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

using Xamarin.Forms;
using Xamarin.Forms.Xaml;
using ProjetBiblioquokka;
using System.Net.Http;
using Newtonsoft.Json;
using System.Security.Cryptography;

namespace ProjetBiblioquokka
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class register : ContentPage
    {
        HttpClient client;
        public register()
        {
            InitializeComponent();
            client = new HttpClient();
        }       

        //Retour sur la page de connexion
        public void NavigateToLogin(object sender, EventArgs e)
        {
            App.Current.MainPage = (new MainPage());
        }

        //Fonction qui déclanche l'inscription
        public async void Register(object sender, EventArgs e)
        {
            string newPass = new Api().PassHash(password.Text,mail.Text);
            new Api().Register(mail.Text, newPass);
            App.Current.MainPage = (new MainPage());

        }

      
    }
}