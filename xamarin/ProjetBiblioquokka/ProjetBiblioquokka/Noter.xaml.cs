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
    public partial class Noter : ContentPage
    {
        private int idUser;
        private Livre leLivre;
        public Noter(int idUser, Livre idLivre)
        {
            InitializeComponent();
            //Initialisation de moultes variables
            this.idUser = idUser;
            this.leLivre = idLivre;
            title.Text = this.leLivre.Name;
            Image.Source = this.leLivre.Image;
            description.Text = this.leLivre.Description;
            noteLivre(this.leLivre.Note, false);
        }

        //Donner la note minimale à un livre
        void notation0(object sender, EventArgs e)
        {
            noteLivre(0, true);
        }

        //Donner la note moyenne à un livre
        void notation1(object sender, EventArgs e)
        {
            noteLivre(1, true);
        }

        //Donner la note maximale à un livre
           void notation2(object sender, EventArgs e)
        {
            noteLivre(2,true);
        }


        //Fonction appelé lors de la note d'un livre
        public void noteLivre(int note,bool clicked)
        {
            note0.Source = "https://momomotus.ddns.net/api_quokka/images/note0.png";
            note1.Source = "https://momomotus.ddns.net/api_quokka/images/note1.png";
            note2.Source = "https://momomotus.ddns.net/api_quokka/images/note2.png";

            switch (note)
            {
                case 0:
                    note0.Source = "https://momomotus.ddns.net/api_quokka/images/note0c.png";
                    break;
                case 1:
                    note1.Source = "https://momomotus.ddns.net/api_quokka/images/note1c.png";
                    break;
                case 2:
                    note2.Source = "https://momomotus.ddns.net/api_quokka/images/note2c.png";
                    break;
                default:
                    break;
            }

            if (clicked== true)
            {
                if (this.leLivre.Note == -1)
                { 
                    new Api().AddNote(note, this.leLivre.Id, this.idUser);
                } else {
                    new Api().ModifNote(note, this.leLivre.Id, this.idUser);
                }
               Return();
            }
        }
        
        //Retour à l'acceuil
        public void Return()
        {
            App.Current.MainPage = (new Acceuil(this.idUser));
        }


        //Bouton de retour à l'acceuil
        public void backButton(object sender, EventArgs e)
        {
            Return();
        }


    }
}