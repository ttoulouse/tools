use Data::Dumper;
use XML::Simple;
use Email::MIME::CreateHTML;
use Switch;
use DBI;

system('curl --silent \'http://shop.factory-express.com/net/WebService.aspx?Login=webmaster@factory-express.com&EncryptedPassword=47B1BBEF53FD1BDC6D8F68F7D9C83F01EF5699D65BA6A48185715B552A05F6F9&EDI_Name=Generic\Products&SELECT_Columns=p.P$
my $xml = XMLin('/root/items.xml',forcearray => 1,SuppressEmpty => "");

for my $items ( @{ $xml->{items} } ) {

# MYSQL CONFIG VARIABLES
$host = "localhost";
$db = "orders";
$user = "root";
$pw = "1Em0nz2525";


# PERL MYSQL CONNECT()
my $dbh   = DBI->connect ("DBI:mysql:database=$db:host=$host",
                           $user,
                           $pw)
                           or die "Can't connect to database: $DBI::errstr\n";

my $th = $dbh->prepare(qq{SELECT COUNT(1) FROM vendorrules WHERE productcode='$items->{ProductCode}->[0]'});
$th->execute();

if ($th->fetch()->[0]) {
}

else {
    if(!$items->{ProductManufacturer}->[0])
    {

    }

    else {
        $sql = $dbh->prepare("INSERT INTO vendorrules (ProductCode,VendorName,VendorProductCode,Cost,IsPrimary,ProductName,ProductPrice,msrp,active) VALUES (\"$items->{ProductCode}->[0]\",\"$items->{ProductManufacturer}->[0]\",\"$items->{Vendor$
        $sql->execute();
    }
}

close(MYFILE);
open(MYFILE, '>ordernum.dat');
print MYFILE $orders->{OrderID}->[0];
close(MYFILE);

}
