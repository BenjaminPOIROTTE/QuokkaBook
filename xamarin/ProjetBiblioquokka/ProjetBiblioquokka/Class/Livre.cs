using System;
using System.Collections.Generic;
using System.Text;

namespace ProjetBiblioquokka.Class
{
    public class Livre
    {
        private int id;
        private string name;
        private string description;
        private string image;
        private int note;
        private string noteURL;

        public int Id { get { return id; } set { id = value; } }
        public string Name { get { return name; } set { name = value; } }
        public string Description { get { return description; } set { description = value; } }
        public int Note { get { return note; } set { note = value; } }
        public string Image { get { return image; } set { image = value; } }
        public string NoteURL { get { return noteURL; } set { noteURL = value; } }

        //Constructeur de livre déjà noté
        public Livre(int id, string name, string description, string image, int note)
        {
            this.id = id;
            this.Name = name;
            this.Description = description;
            this.Image = image;
            this.Note = note;
            this.noteURL = "https://momomotus.ddns.net/api_quokka/images/note" + note + ".png";
        }

        //Constructeur de livre non noté
        public Livre(int id, string name, string description, string image)
        {
            this.id = id;
            this.Name = name;
            this.Description = description;
            this.Image = image;
            this.note = -1;
        }


    }
}
