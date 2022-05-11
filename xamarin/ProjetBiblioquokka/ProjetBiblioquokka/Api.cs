using System;
using System.Collections.Generic;
using System.Text;
using System.Net.Http;
using System.Net.Http.Headers;
using Newtonsoft.Json;
using Newtonsoft.Json.Linq;
using ProjetBiblioquokka;
using ProjetBiblioquokka.Class;
using System.Security.Cryptography;

namespace ProjetBiblioquokka
{
    public class Api
    {
        string apiLink = "https://momomotus.ddns.net/api_quokka/index.php";
        HttpClient client;
        JObject json = new JObject();
        string token = null;
        string RestUrl = "https://momomotus.ddns.net/api_quokka/authenticate.php?checker=GTwKRmbXaUVnYGTKvv8FqpqrwJuSfM2kyH67QazpQKTYVHFy9YVMRLcN7NLmuRD9";

        public Api()
        {
            HttpClientHandler leclient = new HttpClientHandler();
            leclient.ServerCertificateCustomValidationCallback = (sender, cert, chain, sslPolicyErrors) => { return true; };
            this.client = new HttpClient(leclient);
            getToken();
            var authHeader = new AuthenticationHeaderValue("Bearer", this.token);
            client.DefaultRequestHeaders.Authorization = authHeader;
        }

        public void getToken()
        {
            var response = client.GetAsync(RestUrl).Result;
            string content = response.Content.ReadAsStringAsync().Result;
            if (content.ToString() != "error")
            {
                this.token = content.ToString();
            }
        }

        public bool Register(string mail, string password)
        {   
            json.Add("mail", mail);
            json.Add("password", password);
            var content = new StringContent(json.ToString(), Encoding.UTF8, "application/json");
            var response = client.PostAsync(apiLink + "?action=personne", content).Result;
            string result = response.Content.ReadAsStringAsync().Result;
            return true;
        }

 

        public int Login(string mail, string password)
        {
            if(mail.Length < 2 || password.Length < 2)
            {
              
                return 0;
            }
            Console.WriteLine(this.token);
            json.Add("mail", mail);
            json.Add("password", password);
            var content = new StringContent(json.ToString(), Encoding.UTF8, "application/json");
            var response = client.PostAsync(apiLink + "?action=login", content).Result;
            string result = response.Content.ReadAsStringAsync().Result;
            try
            {
                JObject objection = JObject.Parse(result);
                return Convert.ToInt32((objection.GetValue("id")));
            }
            catch
            {
                return 0;
            }
        }

        public List<Livre> GetLivreLu(int id)
        {
            List<Livre> lesLivres = new List<Livre>();
            var response = client.GetAsync(apiLink + "?action=livreUser&id=" + id).Result;
            string result = response.Content.ReadAsStringAsync().Result;
            try
            {
                var dict = JsonConvert.DeserializeObject<JArray>(result);
                foreach (JObject array in dict)
                {
                    int idLivre = Convert.ToInt32(array.GetValue("id"));
                    int note = Convert.ToInt32(array.GetValue("note"));
                    string description = Convert.ToString(array.GetValue("Description"));
                    string name = Convert.ToString(array.GetValue("Nom"));
                    string image = Convert.ToString(array.GetValue("Image"));
                    Livre leLivre = new Livre(idLivre, name, description, image, note);
                    lesLivres.Add(leLivre);
                }
            }
            catch
            {
                
            }
            return lesLivres;
        }

        public List<Livre> GetLivreNonLu(int id)
        {
            List<Livre> lesLivres = new List<Livre>();
            var response = client.GetAsync(apiLink + "?action=livreNonLu&id=" + id).Result;
            string result = response.Content.ReadAsStringAsync().Result;
            try
            {
                var dict = JsonConvert.DeserializeObject<JArray>(result);
                foreach (JObject array in dict)
                {
                    int idLivre = Convert.ToInt32(array.GetValue("id"));
                    string description = Convert.ToString(array.GetValue("Description"));
                    string name = Convert.ToString(array.GetValue("Nom"));
                    string image = Convert.ToString(array.GetValue("Image"));
                    Livre leLivre = new Livre(idLivre, name, description, image);
                    lesLivres.Add(leLivre);
                }
            }
            catch
            {

            }
            return lesLivres;
        }


        public bool AddNote(Int64 Note, Int64 IdLivre, Int64 IdUser)
        {
            json.Add("user", IdUser);
            json.Add("livre", IdLivre);
            json.Add("note", Note);
            Console.Write("un truc");
            var content = new StringContent(json.ToString(), Encoding.UTF8, "application/json");
            var response = client.PostAsync(apiLink + "?action=ajoutNote", content).Result;
            string result = response.Content.ReadAsStringAsync().Result;
            return true;
        }

        public bool ModifNote(Int64 Note, Int64 IdLivre, Int64 IdUser)
        {
            json.Add("user", IdUser);
            json.Add("livre", IdLivre);
            json.Add("note", Note);
            var content = new StringContent(json.ToString(), Encoding.UTF8, "application/json");
            var response = client.PostAsync(apiLink + "?action=updateNote", content).Result;
            string result = response.Content.ReadAsStringAsync().Result;
            return true;
        }

        public string PassHash(string Pass, string login)
        {
            string LogSplit = login.Substring(0, 2);
            string final = LogSplit + Pass;
            using (var md5Hash = MD5.Create())
            {
                // Byte array representation of source string
                var sourceBytes = Encoding.UTF8.GetBytes(final);

                // Generate hash value(Byte Array) for input data
                var hashBytes = md5Hash.ComputeHash(sourceBytes);

                // Convert hash byte array to string
                var hash = BitConverter.ToString(hashBytes).Replace("-", string.Empty);

                return hash;


            }
        }
    }
}
