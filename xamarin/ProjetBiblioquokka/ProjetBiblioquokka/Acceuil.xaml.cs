using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

using Xamarin.Forms;
using Xamarin.Forms.Xaml;
using ProjetBiblioquokka.Class;
using System.Collections.ObjectModel;
using Xamarin.Essentials;

namespace ProjetBiblioquokka
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class Acceuil : ContentPage
    {

        private ObservableCollection<Livre> LesLivresLus;
        private ObservableCollection<Livre> LesLivresNonLus;
        private int idUser;

        public Acceuil(int idUser)
        {
            InitializeComponent();
            //Initialisations de moultes variables
            this.idUser = idUser;
            LesLivresLus = new ObservableCollection<Livre>();
            LesLivresNonLus = new ObservableCollection<Livre>();
            BookView.ItemsSource = this.LesLivresLus;
            BookView2.ItemsSource = this.LesLivresNonLus;
            BookView.ItemSelected += BookView_ItemSelected;
            BookView2.ItemSelected += BookView_ItemSelected;

            //Obtention des livres déjà notés
            List<Livre> lesLivres = new Api().GetLivreLu(this.idUser);
            foreach(Livre livre in lesLivres)
            {
                LesLivresLus.Add(livre);
            }

            //Obtention des livres non notés
            lesLivres = new Api().GetLivreNonLu(this.idUser);
            foreach (Livre livre in lesLivres)
            {
                LesLivresNonLus.Add(livre);
            }

            
        }

        //Fonction permettant d'accèder à la page de notation d'un livre
        private void BookView_ItemSelected(object sender, SelectedItemChangedEventArgs e)
        {
            Livre leLivre = (Livre)e.SelectedItem;
            App.Current.MainPage = (new Noter(this.idUser, leLivre));
        }


        //Fonction de déconnexion
        private void Deco(object sender, EventArgs e)
        {
            idUser = -1;
            App.Current.MainPage = (new MainPage());
        }
    }
}